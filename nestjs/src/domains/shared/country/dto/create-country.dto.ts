import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateCountryDto {
  @ApiProperty()
  @IsString()
  name: string;

  @ApiProperty()
  @IsString()
  isoCode_2: string;

  @ApiProperty()
  @IsString()
  isoCode_3: string;

  @ApiProperty()
  @IsString()
  currencyCode: string;

  @ApiProperty()
  @IsString()
  currencySymbol: string;

  @ApiProperty()
  @IsBoolean()
  symbolLeft: boolean;

  @ApiProperty()
  @IsString()
  decimalPlace: string;

  @ApiProperty()
  @IsString()
  decimalPoint: string;

  @ApiProperty()
  @IsString()
  thousandsPoint: string;

}
