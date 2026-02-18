import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateFaqDto {
  @ApiProperty()
  @IsString()
  question: string;

  @ApiProperty()
  @IsString()
  answer: string;

  @ApiProperty()
  faqCategoryId: any;

  @ApiProperty()
  @IsBoolean()
  live: boolean;

  @ApiProperty()
  @IsInt()
  popularity: number;

}
