#!/usr/bin/env ts-node

import * as fs from 'fs';
import * as path from 'path';

interface DomainJson {
  domain: string;
  namespace: string;
  tenant?: {
    mode: string;
    tenant_table: string;
    tenant_key: string;
  };
  entities: Record<string, EntityDefinition>;
}

interface EntityDefinition {
  table: string;
  aggregate_root?: boolean;
  polymorphic?: boolean;
  timestamps?: boolean;
  soft_deletes?: boolean;
  fillable?: string[];
  policies?: string[];
  fields: Record<string, FieldDefinition>;
  indexes?: IndexDefinition[];
  relations?: RelationDefinition;
  requests?: any;
}

interface FieldDefinition {
  type: string;
  length?: number;
  precision?: number;
  scale?: number;
  nullable?: boolean;
  unique?: boolean;
  index?: boolean;
  default?: any;
  values?: string[];
}

interface IndexDefinition {
  columns: string[];
  type: string;
  unique?: boolean;
}

interface RelationDefinition {
  belongsTo?: Record<string, any>;
  hasMany?: Record<string, any>;
  hasOne?: Record<string, any>;
  morphTo?: Record<string, any>;
  morphMany?: Record<string, any>;
}

class PrismaSchemaGenerator {
  private domainPath: string;
  private outputPath: string;
  private models: string[] = [];
  private enums: Map<string, Set<string>> = new Map();

  constructor() {
    this.domainPath = path.join(__dirname, '..', '..', 'domains');
    this.outputPath = path.join(__dirname, '..', 'prisma', 'schema.prisma');
  }

  generate() {
    console.log('🚀 Generating Prisma schema from domain JSONs...\n');

    // Read all domain JSON files
    const domainFiles = fs.readdirSync(this.domainPath).filter((file) => file.endsWith('.json'));

    if (domainFiles.length === 0) {
      console.error('❌ No domain JSON files found in', this.domainPath);
      process.exit(1);
    }

    // Parse all domains
    const domains: DomainJson[] = [];
    for (const file of domainFiles) {
      const filePath = path.join(this.domainPath, file);
      const content = fs.readFileSync(filePath, 'utf-8');
      domains.push(JSON.parse(content));
      console.log(`✓ Loaded ${file}`);
    }

    // Generate schema
    const schema = this.generateSchema(domains);

    // Write to file
    const dir = path.dirname(this.outputPath);
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
    }
    fs.writeFileSync(this.outputPath, schema);

    console.log(`\n✨ Prisma schema generated successfully at: ${this.outputPath}`);
    console.log(`📊 Generated ${this.models.length} models`);
  }

  private generateSchema(domains: DomainJson[]): string {
    let schema = this.generateHeader();
    schema += this.generateDatasource();
    schema += this.generateGenerator();

    // Generate enums first
    schema += '\n// ========================================\n';
    schema += '// ENUMS\n';
    schema += '// ========================================\n\n';

    for (const domain of domains) {
      for (const [entityName, entity] of Object.entries(domain.entities)) {
        for (const [fieldName, field] of Object.entries(entity.fields)) {
          if (field.type === 'enum' && field.values) {
            const enumName = `${entityName}${this.capitalize(fieldName)}`;
            if (!this.enums.has(enumName)) {
              this.enums.set(enumName, new Set(field.values));
              schema += `enum ${enumName} {\n`;
              for (const value of field.values) {
                schema += `  ${this.toEnumValue(value)}\n`;
              }
              schema += '}\n\n';
            }
          }
        }
      }
    }

    // Generate models
    for (const domain of domains) {
      schema += `\n// ========================================\n`;
      schema += `// ${domain.domain.toUpperCase()} DOMAIN\n`;
      schema += `// ========================================\n\n`;

      for (const [entityName, entity] of Object.entries(domain.entities)) {
        schema += this.generateModel(entityName, entity, domain);
        this.models.push(entityName);
      }
    }

    return schema;
  }

  private generateHeader(): string {
    return `// This file is auto-generated. Do not edit manually.\n// Generated from domain JSON files\n// Run: npm run generate:domain\n\n`;
  }

  private generateDatasource(): string {
    return `datasource db {\n  provider = "postgresql"\n  url      = env("DATABASE_URL")\n}\n\n`;
  }

  private generateGenerator(): string {
    return `generator client {\n  provider = "prisma-client-js"\n}\n\n`;
  }

  private generateModel(entityName: string, entity: EntityDefinition, domain: DomainJson): string {
    let model = `model ${entityName} {\n`;

    // Collect all existing field names (both snake_case and camelCase)
    const existingFields = new Set<string>();
    for (const fieldName of Object.keys(entity.fields)) {
      existingFields.add(fieldName); // Original name (e.g., organisation_id)
      existingFields.add(this.toCamelCase(fieldName)); // CamelCase version (e.g., organisationId)
    }

    // Generate fields
    for (const [fieldName, field] of Object.entries(entity.fields)) {
      model += `  ${this.generateField(fieldName, field, entityName)}\n`;
    }

    // Add timestamps (only if not already defined)
    if (entity.timestamps !== false) {
      if (!existingFields.has('createdAt') && !existingFields.has('created_at')) {
        model += `  createdAt DateTime @default(now()) @map("created_at")\n`;
      }
      if (!existingFields.has('updatedAt') && !existingFields.has('updated_at')) {
        model += `  updatedAt DateTime @updatedAt @map("updated_at")\n`;
      }
    }

    // Add soft deletes
    if (entity.soft_deletes) {
      if (!existingFields.has('deletedAt') && !existingFields.has('deleted_at')) {
        model += `  deletedAt DateTime? @map("deleted_at")\n`;
      }
    }

    // Generate relations
    if (entity.relations) {
      model += this.generateRelations(entity.relations, entityName, existingFields);
    }

    // Add table mapping
    model += `\n  @@map("${entity.table}")\n`;

    // Add indexes (convert column names to camelCase)
    if (entity.indexes) {
      for (const index of entity.indexes) {
        const camelColumns = index.columns.map((col) => this.toCamelCase(col));
        if (index.type === 'unique') {
          model += `  @@unique([${camelColumns.join(', ')}])\n`;
        } else {
          model += `  @@index([${camelColumns.join(', ')}])\n`;
        }
      }
    }

    model += '}\n\n';
    return model;
  }

  private generateField(fieldName: string, field: FieldDefinition, entityName: string): string {
    const prismaType = this.mapToPrismaType(field, entityName, fieldName);
    const nullable = field.nullable ? '?' : '';
    const attributes: string[] = [];

    // Convert snake_case field names to camelCase in Prisma
    const camelFieldName = this.toCamelCase(fieldName);
    const snakeName = fieldName; // Original snake_case name from JSON

    // ID field
    if (fieldName === 'id' && field.type === 'bigIncrements') {
      attributes.push('@id');
      attributes.push('@default(autoincrement())');
    }

    // Default value
    if (field.default !== undefined && fieldName !== 'id') {
      if (typeof field.default === 'boolean') {
        attributes.push(`@default(${field.default})`);
      } else if (typeof field.default === 'string') {
        // For enum fields, convert to UPPER_SNAKE_CASE without quotes
        if (field.type === 'enum') {
          const enumValue = this.toEnumValue(field.default);
          attributes.push(`@default(${enumValue})`);
        } else {
          attributes.push(`@default("${field.default}")`);
        }
      } else {
        attributes.push(`@default(${field.default})`);
      }
    }

    // Unique
    if (field.unique) {
      attributes.push('@unique');
    }

    // Map field name if snake_case !== camelCase
    if (snakeName !== camelFieldName) {
      attributes.push(`@map("${snakeName}")`);
    }

    const attributeStr = attributes.length > 0 ? ' ' + attributes.join(' ') : '';
    return `${camelFieldName} ${prismaType}${nullable}${attributeStr}`;
  }

  private mapToPrismaType(field: FieldDefinition, entityName: string, fieldName: string): string {
    switch (field.type) {
      case 'bigIncrements':
      case 'bigInteger':
      case 'unsignedBigInteger':
        return 'BigInt';
      case 'integer':
      case 'unsignedInteger':
      case 'tinyInteger':
      case 'unsignedTinyInteger':
        return 'Int';
      case 'string':
      case 'char':
      case 'text':
        return 'String';
      case 'boolean':
        return 'Boolean';
      case 'date':
      case 'datetime':
      case 'timestamp':
        return 'DateTime';
      case 'decimal':
        return 'Decimal';
      case 'json':
        return 'Json';
      case 'enum':
        return `${entityName}${this.capitalize(fieldName)}`;
      default:
        return 'String';
    }
  }

  private generateRelations(
    relations: RelationDefinition,
    entityName: string,
    existingFields: Set<string>,
  ): string {
    let relationStr = '';

    // belongsTo - generate FK fields first (only if not already defined)
    if (relations.belongsTo) {
      const fkFieldsToAdd: string[] = [];
      for (const [name, rel] of Object.entries(relations.belongsTo)) {
        const relEntity = rel.entity;
        const fk = rel.fk || `${this.toSnakeCase(relEntity)}Id`;
        const fkCamelCase = this.toCamelCase(fk);

        // Only add if not already defined
        if (!existingFields.has(fkCamelCase) && !existingFields.has(fk)) {
          fkFieldsToAdd.push(`  ${fkCamelCase} BigInt? @map("${fk}")\n`);
        }
      }

      if (fkFieldsToAdd.length > 0) {
        relationStr += '\n  // Foreign Keys\n';
        relationStr += fkFieldsToAdd.join('');
      }
    }

    relationStr += '\n  // Relations\n';

    // belongsTo relations
    if (relations.belongsTo) {
      for (const [name, rel] of Object.entries(relations.belongsTo)) {
        const relEntity = rel.entity;
        const fk = rel.fk || `${this.toSnakeCase(relEntity)}Id`;
        const fkCamelCase = this.toCamelCase(fk);

        // If relation name conflicts with FK field name, rename the relation
        let relationName = name;
        if (relationName === fkCamelCase || existingFields.has(relationName)) {
          // Use entity name in lowercase as relation name
          relationName = relEntity.charAt(0).toLowerCase() + relEntity.slice(1);
          // If still conflicts, add 'Ref' suffix
          if (relationName === fkCamelCase || existingFields.has(relationName)) {
            relationName = name + 'Ref';
          }
        }

        relationStr += `  ${relationName} ${relEntity}? @relation(fields: [${fkCamelCase}], references: [id])\n`;
      }
    }

    // hasMany
    if (relations.hasMany) {
      for (const [name, rel] of Object.entries(relations.hasMany)) {
        relationStr += `  ${name} ${rel.entity}[]\n`;
      }
    }

    // hasOne
    if (relations.hasOne) {
      for (const [name, rel] of Object.entries(relations.hasOne)) {
        relationStr += `  ${name} ${rel.entity}?\n`;
      }
    }

    // morphTo - only add if not already defined in fields
    if (relations.morphTo) {
      for (const [name, rel] of Object.entries(relations.morphTo)) {
        const typeField = `${name}Type`;
        const idField = `${name}Id`;
        const typeFieldSnake = `${name}_type`;
        const idFieldSnake = `${name}_id`;

        // Only add if not already defined
        if (!existingFields.has(typeField) && !existingFields.has(typeFieldSnake)) {
          relationStr += `  ${typeField} String @map("${typeFieldSnake}")\n`;
        }
        if (!existingFields.has(idField) && !existingFields.has(idFieldSnake)) {
          relationStr += `  ${idField} BigInt @map("${idFieldSnake}")\n`;
        }
      }
    }

    return relationStr;
  }

  private capitalize(str: string): string {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  private toSnakeCase(str: string): string {
    return str.replace(/[A-Z]/g, (letter) => `_${letter.toLowerCase()}`).replace(/^_/, '');
  }

  private toCamelCase(str: string): string {
    return str.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
  }

  private toEnumValue(str: string): string {
    return str.toUpperCase().replace(/[^A-Z0-9]/g, '_');
  }
}

// Run generator
const generator = new PrismaSchemaGenerator();
generator.generate();
