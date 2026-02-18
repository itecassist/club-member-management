import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateMemberDto {
  @ApiProperty()
  userId: any;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  title?: string;

  @ApiProperty()
  @IsString()
  firstName: string;

  @ApiProperty()
  @IsString()
  lastName: string;

  @ApiProperty()
  @IsString()
  email: string;

  @ApiProperty()
  @IsString()
  mobilePhone: string;

  @ApiPropertyOptional()
  @IsOptional()
  @Type(() => Date)
  @IsDate()
  dateOfBirth?: Date;

  @ApiProperty()
  @IsEnum(['FEMALE', 'MALE', 'OTHER'])
  gender: 'FEMALE' | 'MALE' | 'OTHER';

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  memberNumber?: string;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  joinedAt: Date;

  @ApiProperty()
  @IsBoolean()
  isActive: boolean;

  @ApiProperty()
  roles: any;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  lastLoginAt: Date;
}
