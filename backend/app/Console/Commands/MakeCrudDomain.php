<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeCrudDomain extends Command
{
    protected $signature = 'app:crud {domain} {entity} {--force}';
    protected $description = 'Generate DDD CRUD scaffolding from domain JSON';

    public function handle()
    {
        $domain = $this->argument('domain');
        $entity = $this->argument('entity');

        $path = dirname(base_path()) . "/domains/" . strtolower($domain) . ".json";

        if (!File::exists($path)) {
            $this->error("Domain JSON not found: {$path}");
            return 1;
        }

        $spec = json_decode(File::get($path), true);

        if (!isset($spec['entities'][$entity])) {
            $this->error("Entity {$entity} not found in {$domain}");
            return 1;
        }

        $this->generateDomain($spec, $domain, $entity);

        $this->info("Generated {$domain} / {$entity}");
        return 0;
    }

    /* ---------- CORE ---------- */

    protected function isAggregateRoot(array $spec, string $entity): bool
    {
        return !empty($spec['entities'][$entity]['aggregate_root']);
    }

    protected function generateDomain(array $spec, string $domain, string $entity)
    {
        $base = app_path("Domains/{$domain}");
        File::ensureDirectoryExists($base);

        foreach (['Models', 'Actions', 'DTOs', 'Policies', 'Events', 'Repositories'] as $dir) {
            File::ensureDirectoryExists("{$base}/{$dir}");
        }

        $this->generateModel($spec, $domain, $entity);
        $this->generateMigration($spec, $entity);
        $this->generateRequests($spec, $entity);

        if ($this->isAggregateRoot($spec, $entity)) {
            $this->generateDto($spec, $domain, $entity);
            $this->generateRepository($spec, $domain, $entity);
            $this->generateActions($spec, $domain, $entity);
            $this->generateEvents($spec, $domain, $entity);
            $this->generateController($domain, $entity);
            $this->generateRoutes($domain, $entity);
            $this->generatePolicy($spec, $domain, $entity);
        }
    }

    /* ---------- MODEL ---------- */

    protected function generateModel(array $spec, string $domain, string $entity)
    {
        $namespace = "App\\Domains\\{$domain}\\Models";
        $file = app_path("Domains/{$domain}/Models/{$entity}.php");

        if (File::exists($file) && !$this->option('force')) return;

        $table = $spec['entities'][$entity]['table'];
        $relations = $spec['entities'][$entity]['relations'] ?? [];
        $fillable = $spec['entities'][$entity]['fillable'] ?? [];
        $isPolymorphic = !empty($spec['entities'][$entity]['polymorphic']);

        $imports = [];
        $methods = '';
        $traits = '';

        // Add TenantScoped trait if entity has organisation_id
        $fields = $spec['entities'][$entity]['fields'] ?? [];
        if (isset($fields['organisation_id'])) {
            $imports['App\Shared\Tenancy\TenantScoped'] = 'TenantScoped';
            $traits = 'use TenantScoped;';
        }

        // Generate fillable
        $fillableStr = '';
        if (!empty($fillable)) {
            $fillableArray = "'" . implode("', '", $fillable) . "'";
            $fillableStr = "\n    protected \$fillable = [{$fillableArray}];";
        }

        // Handle belongsTo relations
        foreach ($relations['belongsTo'] ?? [] as $name => $rel) {
            $fqcn = "App\\Domains\\{$rel['domain']}\\Models\\{$rel['entity']}";
            $imports[$fqcn] = $rel['entity'];

            $methods .= <<<PHP

    public function {$name}()
    {
        return \$this->belongsTo({$rel['entity']}::class, '{$rel['fk']}');
    }

PHP;
        }

        // Handle hasMany relations
        foreach ($relations['hasMany'] ?? [] as $name => $rel) {
            $fqcn = "App\\Domains\\{$rel['domain']}\\Models\\{$rel['entity']}";
            $imports[$fqcn] = $rel['entity'];

            $methods .= <<<PHP

    public function {$name}()
    {
        return \$this->hasMany({$rel['entity']}::class, '{$rel['fk']}');
    }

PHP;
        }

        // Handle hasOne relations
        foreach ($relations['hasOne'] ?? [] as $name => $rel) {
            $fqcn = "App\\Domains\\{$rel['domain']}\\Models\\{$rel['entity']}";
            $imports[$fqcn] = $rel['entity'];

            $methods .= <<<PHP

    public function {$name}()
    {
        return \$this->hasOne({$rel['entity']}::class, '{$rel['fk']}');
    }

PHP;
        }

        // Handle morphTo relations
        foreach ($relations['morphTo'] ?? [] as $name => $rel) {
            $methods .= <<<PHP

    public function {$name}()
    {
        return \$this->morphTo();
    }

PHP;
        }

        // Handle morphMany relations
        foreach ($relations['morphMany'] ?? [] as $name => $rel) {
            $fqcn = "App\\Domains\\{$rel['domain']}\\Models\\{$rel['entity']}";
            $imports[$fqcn] = $rel['entity'];

            $morphName = $rel['morph'];
            $methods .= <<<PHP

    public function {$name}()
    {
        return \$this->morphMany({$rel['entity']}::class, '{$morphName}');
    }

PHP;
        }

        $useLines = '';
        foreach ($imports as $fqcn => $short) {
            $useLines .= "use {$fqcn};\n";
        }

        $stub = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;
{$useLines}
class {$entity} extends Model
{
    {$traits}
    protected \$table = '{$table}';{$fillableStr}
{$methods}
}
PHP;

        File::put($file, $stub);
    }

    /* ---------- MIGRATION ---------- */

    protected function generateMigration(array $spec, string $entity)
    {
        $table = $spec['entities'][$entity]['table'];
        $dir = database_path('migrations');

        // 1. Delete ALL legacy migrations for this table
        foreach (glob($dir . "/*create_{$table}_table.php") as $old) {
            unlink($old);
        }

        // 2. Write canonical migration
        $file = $dir . "/create_{$table}_table.php";

        $fields = $spec['entities'][$entity]['fields'];
        $indexes = $spec['entities'][$entity]['indexes'] ?? [];
        $timestamps = $spec['entities'][$entity]['timestamps'] ?? true;

        $cols = '';
        foreach ($fields as $name => $f) {
            $cols .= $this->generateFieldDefinition($name, $f);
        }

        // Add indexes
        $indexDefs = '';
        foreach ($indexes as $idx) {
            $columns = implode("', '", $idx['columns']);
            $indexDefs .= "\$table->index(['{$columns}']);\n            ";
        }

        $timestampLine = $timestamps ? "\$table->timestamps();" : "";

        $stub = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('{$table}');
        Schema::create('{$table}', function (Blueprint \$table) {
            {$cols}{$indexDefs}{$timestampLine}
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;

        file_put_contents($file, $stub);
    }

    protected function generateFieldDefinition(string $name, array $f): string
    {
        $def = '';
        $nullable = !empty($f['nullable']) ? '->nullable()' : '';
        $default = isset($f['default']) ? $this->formatDefault($f['default'], $f['type']) : '';
        $unique = !empty($f['unique']) ? '->unique()' : '';
        $index = !empty($f['index']) ? '->index()' : '';

        switch ($f['type']) {
            case 'bigIncrements':
                $def = "\$table->bigIncrements('{$name}')";
                break;

            case 'string':
                $len = $f['length'] ?? 255;
                $def = "\$table->string('{$name}', {$len})";
                break;

            case 'char':
                $len = $f['length'] ?? 1;
                $def = "\$table->char('{$name}', {$len})";
                break;

            case 'text':
                $def = "\$table->text('{$name}')";
                break;

            case 'unsignedBigInteger':
                $def = "\$table->unsignedBigInteger('{$name}')";
                break;

            case 'unsignedInteger':
                $def = "\$table->unsignedInteger('{$name}')";
                break;

            case 'unsignedTinyInteger':
                $def = "\$table->unsignedTinyInteger('{$name}')";
                break;

            case 'integer':
                $def = "\$table->integer('{$name}')";
                break;

            case 'decimal':
                $precision = $f['precision'] ?? 8;
                $scale = $f['scale'] ?? 2;
                $def = "\$table->decimal('{$name}', {$precision}, {$scale})";
                break;

            case 'enum':
                $vals = implode("','", $f['values']);
                $def = "\$table->enum('{$name}', ['{$vals}'])";
                break;

            case 'boolean':
                $def = "\$table->boolean('{$name}')";
                break;

            case 'date':
                $def = "\$table->date('{$name}')";
                break;

            case 'datetime':
                $def = "\$table->dateTime('{$name}')";
                break;

            case 'timestamp':
                $def = "\$table->timestamp('{$name}')";
                break;

            case 'json':
                $def = "\$table->json('{$name}')";
                break;

            default:
                $def = "\$table->string('{$name}')";
        }

        return "{$def}{$nullable}{$default}{$unique}{$index};\n            ";
    }

    protected function formatDefault($value, string $type): string
    {
        if ($type === 'boolean') {
            return "->default(" . ($value ? 'true' : 'false') . ")";
        } elseif ($type === 'string' || $type === 'char' || $type === 'enum') {
            return "->default('{$value}')";
        } elseif (is_numeric($value)) {
            return "->default({$value})";
        }
        return "->default('{$value}')";
    }

    /* ---------- REQUESTS ---------- */

    protected function generateRequests(array $spec, string $entity)
    {
        if (!isset($spec['entities'][$entity]['requests'])) return;

        $dir = app_path('Http/Requests');
        File::ensureDirectoryExists($dir);

        foreach ($spec['entities'][$entity]['requests'] as $requestType => $r) {
            $className = $r['class'];
            $file = "{$dir}/{$className}.php";
            if (file_exists($file) && !$this->option('force')) continue;

            $rules = $this->formatRulesArray($r['rules']);

            file_put_contents($file, <<<PHP
<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class {$className} extends FormRequest {
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return {$rules};
    }
}
PHP);
        }
    }

    protected function formatRulesArray(array $rules): string
    {
        $lines = [];
        foreach ($rules as $field => $fieldRules) {
            $rulesStr = "'" . implode("', '", $fieldRules) . "'";
            $lines[] = "            '{$field}' => [{$rulesStr}]";
        }
        return "[\n" . implode(",\n", $lines) . "\n        ]";
    }

    /* ---------- DTO ---------- */

    protected function generateDto(array $spec, string $domain, string $entity)
    {
        $ns    = "App\\Domains\\{$domain}\\DTOs";
        $class = "{$entity}Data";
        $file  = app_path("Domains/{$domain}/DTOs/{$class}.php");

        if (file_exists($file) && !$this->option('force')) return;

        $fillable = $spec['entities'][$entity]['fillable'] ?? [];
        $fields   = $spec['entities'][$entity]['fields'] ?? [];
        $skip     = ['id', 'organisation_id', 'created_at', 'updated_at'];

        $props     = [];
        $fromArray = [];
        $toArray   = [];

        foreach ($fillable as $fieldName) {
            if (in_array($fieldName, $skip)) continue;

            $fieldSpec = $fields[$fieldName] ?? ['type' => 'string'];
            $phpType   = $this->phpTypeFromField($fieldSpec);
            $nullable  = !empty($fieldSpec['nullable']);
            $typeHint  = ($nullable ? '?' : '') . $phpType;
            $camel     = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName))));

            $props[]     = "        public readonly {$typeHint} \${$camel},";
            $fromArray[] = "            {$camel}: \$data['{$fieldName}']" . ($nullable ? " ?? null," : ",");
            $toArray[]   = "            '{$fieldName}' => \$this->{$camel},";
        }

        $propsStr     = implode("\n", $props);
        $fromArrayStr = implode("\n", $fromArray);
        $toArrayStr   = implode("\n", $toArray);

        $stub = <<<PHP
<?php

namespace {$ns};

readonly class {$class}
{
    public function __construct(
{$propsStr}
    ) {}

    public static function fromArray(array \$data): self
    {
        return new self(
{$fromArrayStr}
        );
    }

    public function toArray(): array
    {
        return [
{$toArrayStr}
        ];
    }
}
PHP;

        file_put_contents($file, $stub);
    }

    protected function phpTypeFromField(array $fieldSpec): string
    {
        return match ($fieldSpec['type']) {
            'bigIncrements', 'unsignedBigInteger', 'unsignedInteger', 'unsignedTinyInteger', 'integer' => 'int',
            'boolean' => 'bool',
            'json'    => 'array',
            default   => 'string',
        };
    }

    /* ---------- REPOSITORY ---------- */

    protected function generateRepository(array $spec, string $domain, string $entity)
    {
        $ns      = "App\\Domains\\{$domain}\\Repositories";
        $modelNs = "App\\Domains\\{$domain}\\Models\\{$entity}";
        $dtoNs   = "App\\Domains\\{$domain}\\DTOs\\{$entity}Data";
        $file    = app_path("Domains/{$domain}/Repositories/{$entity}Repository.php");

        if (file_exists($file) && !$this->option('force')) return;

        file_put_contents($file, <<<PHP
<?php

namespace {$ns};

use {$modelNs};
use {$dtoNs};

class {$entity}Repository
{
    public function create({$entity}Data \$data): {$entity}
    {
        return {$entity}::create(\$data->toArray());
    }

    public function update({$entity} \$model, {$entity}Data \$data): {$entity}
    {
        \$model->update(\$data->toArray());
        return \$model;
    }

    public function find(int \$id): ?{$entity}
    {
        return {$entity}::find(\$id);
    }

    public function findOrFail(int \$id): {$entity}
    {
        return {$entity}::findOrFail(\$id);
    }

    public function paginate(int \$perPage = 15)
    {
        return {$entity}::paginate(\$perPage);
    }

    public function delete({$entity} \$model): void
    {
        \$model->delete();
    }
}
PHP);
    }

    /* ---------- ACTIONS ---------- */

    protected function generateActions(array $spec, string $domain, string $entity)
    {
        $repoNs    = "App\\Domains\\{$domain}\\Repositories\\{$entity}Repository";
        $modelNs   = "App\\Domains\\{$domain}\\Models\\{$entity}";
        $dtoNs     = "App\\Domains\\{$domain}\\DTOs\\{$entity}Data";
        $eventNs   = "App\\Domains\\{$domain}\\Events\\{$entity}Created";
        $hasOrgId  = isset($spec['entities'][$entity]['fields']['organisation_id']);

        $eventLine = $hasOrgId
            ? "event(new {$entity}Created(\$model->id, \$model->organisation_id));"
            : "event(new {$entity}Created(\$model->id));";

        // Create action
        file_put_contents(app_path("Domains/{$domain}/Actions/Create{$entity}.php"), <<<PHP
<?php

namespace App\\Domains\\{$domain}\\Actions;

use {$repoNs};
use {$modelNs};
use {$dtoNs};
use {$eventNs};

class Create{$entity}
{
    public function __construct(protected {$entity}Repository \$repo) {}

    public function execute({$entity}Data \$data): {$entity}
    {
        \$model = \$this->repo->create(\$data);
        {$eventLine}
        return \$model;
    }
}
PHP);

        // Update action
        file_put_contents(app_path("Domains/{$domain}/Actions/Update{$entity}.php"), <<<PHP
<?php

namespace App\\Domains\\{$domain}\\Actions;

use {$repoNs};
use {$modelNs};
use {$dtoNs};

class Update{$entity}
{
    public function __construct(protected {$entity}Repository \$repo) {}

    public function execute({$entity}Data \$data, {$entity} \$model): {$entity}
    {
        return \$this->repo->update(\$model, \$data);
    }
}
PHP);

        // Delete action
        file_put_contents(app_path("Domains/{$domain}/Actions/Delete{$entity}.php"), <<<PHP
<?php

namespace App\\Domains\\{$domain}\\Actions;

use {$repoNs};
use {$modelNs};

class Delete{$entity}
{
    public function __construct(protected {$entity}Repository \$repo) {}

    public function execute({$entity} \$model): void
    {
        \$this->repo->delete(\$model);
    }
}
PHP);
    }

    /* ---------- EVENTS ---------- */

    protected function generateEvents(array $spec, string $domain, string $entity)
    {
        $hasOrgId = isset($spec['entities'][$entity]['fields']['organisation_id']);

        // Always generate {Entity}Created for aggregate roots
        $createdFile = app_path("Domains/{$domain}/Events/{$entity}Created.php");
        if (!file_exists($createdFile) || $this->option('force')) {
            $constructor = $hasOrgId
                ? "public function __construct(public readonly int \$id, public readonly int \$organisationId) {}"
                : "public function __construct(public readonly int \$id) {}";

            file_put_contents($createdFile, <<<PHP
<?php

namespace App\\Domains\\{$domain}\\Events;

class {$entity}Created
{
    {$constructor}
}
PHP);
        }

        // Generate any additional events from spec
        foreach ($spec['entities'][$entity]['events'] ?? [] as $e) {
            $file = app_path("Domains/{$domain}/Events/{$e['name']}.php");
            if (!file_exists($file) || $this->option('force')) {
                file_put_contents($file, "<?php\nnamespace App\\Domains\\{$domain}\\Events;\nclass {$e['name']} {}\n");
            }
        }
    }

    /* ---------- CONTROLLER ---------- */

    protected function generateController(string $domain, string $entity)
    {
        $dir = app_path("Http/Controllers/{$domain}");
        File::ensureDirectoryExists($dir);

        file_put_contents("{$dir}/{$entity}Controller.php", <<<PHP
<?php

namespace App\\Http\\Controllers\\{$domain};

use App\\Domains\\{$domain}\\Actions\\Create{$entity};
use App\\Domains\\{$domain}\\Actions\\Delete{$entity};
use App\\Domains\\{$domain}\\Actions\\Update{$entity};
use App\\Domains\\{$domain}\\DTOs\\{$entity}Data;
use App\\Domains\\{$domain}\\Repositories\\{$entity}Repository;
use App\\Http\\Requests\\Store{$entity}Request;
use App\\Http\\Requests\\Update{$entity}Request;
use Illuminate\\Http\\JsonResponse;

class {$entity}Controller
{
    public function __construct(
        protected {$entity}Repository \$repo,
        protected Create{$entity} \$create,
        protected Update{$entity} \$update,
        protected Delete{$entity} \$delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(\$this->repo->paginate());
    }

    public function show(int \$id): JsonResponse
    {
        return response()->json(\$this->repo->findOrFail(\$id));
    }

    public function store(Store{$entity}Request \$r): JsonResponse
    {
        \$model = \$this->create->execute({$entity}Data::fromArray(\$r->validated()));
        return response()->json(\$model, 201);
    }

    public function update(Update{$entity}Request \$r, int \$id): JsonResponse
    {
        \$model = \$this->update->execute(
            {$entity}Data::fromArray(\$r->validated()),
            \$this->repo->findOrFail(\$id)
        );
        return response()->json(\$model);
    }

    public function destroy(int \$id): JsonResponse
    {
        \$this->delete->execute(\$this->repo->findOrFail(\$id));
        return response()->json(null, 204);
    }
}
PHP);
    }

    /* ---------- ROUTES ---------- */

    protected function generateRoutes(string $domain, string $entity)
    {
        $file = base_path("routes/{$domain}.php");
        $ctrl = "App\\Http\\Controllers\\{$domain}\\{$entity}Controller";
        $resourceName = strtolower($entity) . 's';
        $routeLine = "Route::apiResource('{$resourceName}', {$entity}Controller::class);";

        // Create file if it doesn't exist
        if (!file_exists($file)) {
            file_put_contents($file, "<?php\n\nuse {$ctrl};\n\n");
        }

        // Read existing content
        $content = file_get_contents($file);

        // Check if route already exists
        if (strpos($content, $routeLine) !== false) {
            return; // Route already exists, skip
        }

        // Check if controller is imported
        if (strpos($content, "use {$ctrl};") === false) {
            // Add import after existing imports or after <?php
            $lines = explode("\n", $content);
            $insertAt = 1; // After <?php

            // Find last import line
            foreach ($lines as $i => $line) {
                if (strpos($line, 'use ') === 0) {
                    $insertAt = $i + 1;
                }
            }

            array_splice($lines, $insertAt, 0, "use {$ctrl};");
            $content = implode("\n", $lines);
        }

        // Append route
        file_put_contents($file, $content . "\n{$routeLine}\n");
    }

    /* ---------- POLICY ---------- */

    protected function generatePolicy(array $spec, string $domain, string $entity)
    {
        if (empty($spec['entities'][$entity]['policies'])) return;

        $ns    = "App\\Domains\\{$domain}\\Policies";
        $model = "App\\Domains\\{$domain}\\Models\\{$entity}";
        $file  = app_path("Domains/{$domain}/Policies/{$entity}Policy.php");

        if (file_exists($file) && !$this->option('force')) return;

        $methods = '';

        foreach ($spec['entities'][$entity]['policies'] as $ability) {
            $methods .= <<<PHP

    public function {$ability}(\\App\\Models\\User \$user, {$entity} \${$entity})
    {
        return \$user->organisation_id === \${$entity}->organisation_id;
    }

PHP;
        }

        $stub = <<<PHP
<?php

namespace {$ns};

use {$model};

class {$entity}Policy
{
{$methods}
}
PHP;

        File::put($file, $stub);
    }
}
