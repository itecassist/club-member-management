import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateArticleDto {
  @ApiProperty()
  @IsInt()
  type: number;

  @ApiProperty()
  @IsString()
  title: string;

  @ApiProperty()
  articleCategoryId: any;

  @ApiProperty()
  @IsString()
  pageTitle: string;

  @ApiProperty()
  @IsString()
  seoName: string;

  @ApiProperty()
  @IsString()
  content: string;

  @ApiProperty()
  @IsString()
  summary: string;

  @ApiProperty()
  @IsString()
  seoDescription: string;

  @ApiProperty()
  @IsBoolean()
  featured: boolean;

  @ApiProperty()
  @IsBoolean()
  live: boolean;

  @ApiProperty()
  @IsBoolean()
  categoryLive: boolean;

  @ApiProperty()
  @IsInt()
  popularity: number;

}
