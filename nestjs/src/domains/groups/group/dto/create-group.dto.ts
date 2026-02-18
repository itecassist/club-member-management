import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateGroupDto {
  @ApiProperty()
  @IsString()
  name: string;

  @ApiProperty()
  @IsEnum(['FAMILY', 'CORPORATE', 'CLUB', 'COMMITTEE', 'OTHER'])
  type: 'FAMILY' | 'CORPORATE' | 'CLUB' | 'COMMITTEE' | 'OTHER';

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  description?: string;

  @ApiPropertyOptional()
  @IsOptional()
  primaryAdminId?: any;

  @ApiPropertyOptional()
  @IsOptional()
  @IsInt()
  maxMembers?: number;

  @ApiProperty()
  @IsBoolean()
  isActive: boolean;
}
