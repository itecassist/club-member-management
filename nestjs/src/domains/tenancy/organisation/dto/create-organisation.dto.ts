import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateOrganisationDto {
  @ApiProperty()
  @IsString()
  name: string;

  @ApiProperty()
  @IsString()
  seoName: string;

  @ApiProperty()
  @IsString()
  email: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  phone?: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  logo?: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  website?: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  description?: string;

  @ApiProperty()
  @IsBoolean()
  freeTrail: boolean;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  freeTrailEndDate: Date;

  @ApiProperty()
  @IsEnum(['DEBIT_ORDER', 'WALLET', 'INVOICE'])
  billingPolicy: 'DEBIT_ORDER' | 'WALLET' | 'INVOICE';

  @ApiProperty()
  @IsBoolean()
  isActive: boolean;
}
