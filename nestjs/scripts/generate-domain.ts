#!/usr/bin/env ts-node

import * as fs from 'fs';
import * as path from 'path';

interface DomainJson {
  domain: string;
  namespace: string;
  tenant?: any;
  entities: Record<string, EntityDefinition>;
}

interface EntityDefinition {
  table: string;
  aggregate_root?: boolean;
  fillable?: string[];
  fields: Record<string, FieldDefinition>;
  relations?: RelationDefinition;
  requests?: any;
}

interface FieldDefinition {
  type: string;
  nullable?: boolean;
  values?: string[];
  length?: number;
}

interface RelationDefinition {
  belongsTo?: Record<string, any>;
  hasMany?: Record<string, any>;
  hasOne?: Record<string, any>;
  morphTo?: Record<string, any>;
  morphMany?: Record<string, any>;
}

class NestJSCrudGenerator {
  private domainPath: string;
  private srcPath: string;

  constructor() {
    this.domainPath = path.join(__dirname, '..', '..', 'domains');
    this.srcPath = path.join(__dirname, '..', 'src', 'domains');
  }

  generate(domainName?: string, entityName?: string) {
    console.log('🚀 Generating NestJS CRUD modules...\n');

    const domainFiles = fs
      .readdirSync(this.domainPath)
      .filter(
        (file) =>
          file.endsWith('.json') && (!domainName || file === `${domainName.toLowerCase()}.json`),
      );

    for (const file of domainFiles) {
      const filePath = path.join(this.domainPath, file);
      const content = fs.readFileSync(filePath, 'utf-8');
      const domain: DomainJson = JSON.parse(content);

      console.log(`📦 Processing ${domain.domain} domain...`);

      for (const [entity, definition] of Object.entries(domain.entities)) {
        if (entityName && entity !== entityName) continue;
        if (definition.aggregate_root) {
          this.generateCrud(domain, entity, definition);
        }
      }
    }

    console.log('\n✨ CRUD generation complete!');
  }

  private generateCrud(domain: DomainJson, entityName: string, definition: EntityDefinition) {
    const domainFolder = path.join(this.srcPath, domain.domain.toLowerCase());
    const entityFolder = path.join(domainFolder, entityName.toLowerCase());

    // Create directories
    if (!fs.existsSync(entityFolder)) {
      fs.mkdirSync(entityFolder, { recursive: true });
    }

    this.generateModule(domainFolder, domain, entityName, definition);
    this.generateController(entityFolder, domain, entityName, definition);
    this.generateService(entityFolder, domain, entityName, definition);
    this.generateDtos(entityFolder, domain, entityName, definition);

    console.log(`  ✓ Generated ${entityName} module`);
  }

  private generateModule(
    domainFolder: string,
    domain: DomainJson,
    entityName: string,
    definition: EntityDefinition,
  ) {
    const moduleName = `${entityName}Module`;
    const controllerName = `${entityName}Controller`;
    const serviceName = `${entityName}Service`;
    const lowerEntity = entityName.toLowerCase();

    const content = `import { Module } from '@nestjs/common';
import { ${controllerName} } from './${lowerEntity}/${lowerEntity}.controller';
import { ${serviceName} } from './${lowerEntity}/${lowerEntity}.service';

@Module({
  controllers: [${controllerName}],
  providers: [${serviceName}],
  exports: [${serviceName}],
})
export class ${moduleName} {}
`;

    const modulePath = path.join(domainFolder, `${lowerEntity}.module.ts`);
    fs.writeFileSync(modulePath, content);
  }

  private generateController(
    entityFolder: string,
    domain: DomainJson,
    entityName: string,
    definition: EntityDefinition,
  ) {
    const lowerEntity = entityName.toLowerCase();
    const serviceName = `${entityName}Service`;
    const createDto = `Create${entityName}Dto`;
    const updateDto = `Update${entityName}Dto`;

    const content = `import {
  Controller,
  Get,
  Post,
  Put,
  Delete,
  Body,
  Param,
  Query,
  UseGuards,
  ParseIntPipe,
} from '@nestjs/common';
import { ApiTags, ApiOperation, ApiBearerAuth } from '@nestjs/swagger';
import { ${serviceName} } from './${lowerEntity}.service';
import { ${createDto}, ${updateDto} } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('${domain.domain.toLowerCase()}')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('${lowerEntity}s')
export class ${entityName}Controller {
  constructor(private readonly ${lowerEntity}Service: ${serviceName}) {}

  @Get()
  @ApiOperation({ summary: 'Get all ${lowerEntity}s' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.${lowerEntity}Service.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get ${lowerEntity} by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.${lowerEntity}Service.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create ${lowerEntity}' })
  create(@Body() dto: ${createDto}, @CurrentTenant() tenantId: number) {
    return this.${lowerEntity}Service.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update ${lowerEntity}' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: ${updateDto},
    @CurrentTenant() tenantId: number,
  ) {
    return this.${lowerEntity}Service.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete ${lowerEntity}' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.${lowerEntity}Service.remove(id, tenantId);
  }
}
`;

    const controllerPath = path.join(entityFolder, `${lowerEntity}.controller.ts`);
    fs.writeFileSync(controllerPath, content);
  }

  private generateService(
    entityFolder: string,
    domain: DomainJson,
    entityName: string,
    definition: EntityDefinition,
  ) {
    const lowerEntity = entityName.toLowerCase();
    const createDto = `Create${entityName}Dto`;
    const updateDto = `Update${entityName}Dto`;
    const hasTenant = definition.fields.organisation_id || definition.fields.organizationId;

    const content = `import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { ${createDto}, ${updateDto} } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class ${entityName}Service {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = ${hasTenant ? '{ organisationId: tenantId }' : '{}'};

    const [items, total] = await Promise.all([
      this.prisma.${lowerEntity}.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.${lowerEntity}.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const ${lowerEntity} = await this.prisma.${lowerEntity}.findFirst({
      where: { ${hasTenant ? 'id, organisationId: tenantId' : 'id'} },
    });

    if (!${lowerEntity}) {
      throw new NotFoundException('${entityName} not found');
    }

    return ${lowerEntity};
  }

  async create(dto: ${createDto}, tenantId: number) {
    return this.prisma.${lowerEntity}.create({
      data: {
        ...dto,${hasTenant ? '\n        organisationId: tenantId,' : ''}
      },
    });
  }

  async update(id: number, dto: ${updateDto}, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.${lowerEntity}.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.${lowerEntity}.delete({
      where: { id },
    });

    return { message: '${entityName} deleted successfully' };
  }
}
`;

    const servicePath = path.join(entityFolder, `${lowerEntity}.service.ts`);
    fs.writeFileSync(servicePath, content);
  }

  private generateDtos(
    entityFolder: string,
    domain: DomainJson,
    entityName: string,
    definition: EntityDefinition,
  ) {
    const dtoFolder = path.join(entityFolder, 'dto');
    if (!fs.existsSync(dtoFolder)) {
      fs.mkdirSync(dtoFolder, { recursive: true });
    }

    // Generate Create DTO
    const createDtoContent = this.generateCreateDto(entityName, definition);
    fs.writeFileSync(
      path.join(dtoFolder, `create-${entityName.toLowerCase()}.dto.ts`),
      createDtoContent,
    );

    // Generate Update DTO
    const updateDtoContent = this.generateUpdateDto(entityName);
    fs.writeFileSync(
      path.join(dtoFolder, `update-${entityName.toLowerCase()}.dto.ts`),
      updateDtoContent,
    );

    // Generate index
    const indexContent = `export * from './create-${entityName.toLowerCase()}.dto';\nexport * from './update-${entityName.toLowerCase()}.dto';\n`;
    fs.writeFileSync(path.join(dtoFolder, 'index.ts'), indexContent);
  }

  private generateCreateDto(entityName: string, definition: EntityDefinition): string {
    let content = `import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';\n`;
    content += `import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';\n`;
    content += `import { Type } from 'class-transformer';\n\n`;

    content += `export class Create${entityName}Dto {\n`;

    for (const [fieldName, field] of Object.entries(definition.fields)) {
      // Skip auto-generated fields
      if (['id', 'created_at', 'updated_at', 'deleted_at', 'organisation_id'].includes(fieldName)) {
        continue;
      }

      // Convert field name to camelCase
      const camelFieldName = this.toCamelCase(fieldName);
      const isOptional = field.nullable;
      const decorator = isOptional ? '@ApiPropertyOptional' : '@ApiProperty';

      content += `  ${decorator}()\n`;

      // Add validators
      const validators = this.getValidators(field);
      validators.forEach((v) => {
        content += `  ${v}\n`;
      });

      const tsType = this.mapToTypeScriptType(field);
      content += `  ${camelFieldName}${isOptional ? '?' : ''}: ${tsType};\n\n`;
    }

    content += `}\n`;
    return content;
  }

  private generateUpdateDto(entityName: string): string {
    return `import { PartialType } from '@nestjs/swagger';
import { Create${entityName}Dto } from './create-${entityName.toLowerCase()}.dto';

export class Update${entityName}Dto extends PartialType(Create${entityName}Dto) {}
`;
  }

  private getValidators(field: FieldDefinition): string[] {
    const validators: string[] = [];

    if (field.nullable) {
      validators.push('@IsOptional()');
    }

    switch (field.type) {
      case 'string':
      case 'text':
      case 'char':
        validators.push('@IsString()');
        break;
      case 'integer':
      case 'bigInteger':
      case 'unsignedInteger':
      case 'tinyInteger':
        validators.push('@IsInt()');
        break;
      case 'boolean':
        validators.push('@IsBoolean()');
        break;
      case 'date':
      case 'datetime':
      case 'timestamp':
        validators.push('@Type(() => Date)');
        validators.push('@IsDate()');
        break;
      case 'enum':
        if (field.values) {
          validators.push(`@IsEnum([${field.values.map((v) => `'${v}'`).join(', ')}])`);
        }
        break;
    }

    return validators;
  }

  private mapToTypeScriptType(field: FieldDefinition): string {
    switch (field.type) {
      case 'bigInteger':
      case 'integer':
      case 'unsignedInteger':
      case 'tinyInteger':
      case 'decimal':
        return 'number';
      case 'string':
      case 'text':
      case 'char':
        return 'string';
      case 'boolean':
        return 'boolean';
      case 'date':
      case 'datetime':
      case 'timestamp':
        return 'Date';
      case 'json':
        return 'any';
      case 'enum':
        return field.values ? field.values.map((v) => `'${v}'`).join(' | ') : 'string';
      default:
        return 'any';
    }
  }

  private toCamelCase(str: string): string {
    return str.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
  }
}

// Parse command line arguments
const args = process.argv.slice(2);
const domainArg = args.find((arg) => arg.startsWith('--domain='));
const entityArg = args.find((arg) => arg.startsWith('--entity='));

const domainName = domainArg?.split('=')[1];
const entityName = entityArg?.split('=')[1];

const generator = new NestJSCrudGenerator();
generator.generate(domainName, entityName);
