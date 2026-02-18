import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateSubscriptionDto {
  @ApiProperty()
  @IsString()
  name: string;

  @ApiProperty()
  @IsString()
  description: string;

  @ApiPropertyOptional()
  @IsOptional()
  virtualFormId?: any;

  @ApiPropertyOptional()
  @IsOptional()
  documentId?: any;

  @ApiProperty()
  @IsEnum(['BASIC', 'OTHER'])
  membership: 'BASIC' | 'OTHER';

  @ApiProperty()
  @IsEnum(['INDIVIDUAL', 'GROUP'])
  membershipType: 'INDIVIDUAL' | 'GROUP';

  @ApiProperty()
  @IsEnum(['DAILY', 'WEEKLY', 'MONTHLY', 'YEARLY', 'LIFETIME', 'NO_PERIOD', 'INSTALLMENTS'])
  period: 'DAILY' | 'WEEKLY' | 'MONTHLY' | 'YEARLY' | 'LIFETIME' | 'NO_PERIOD' | 'INSTALLMENTS';

  @ApiProperty()
  @IsEnum(['FIXED_END_DATE', 'INDIVIDUAL_ANNIVERSARY', 'NOT_RENEWABLE'])
  renewals: 'FIXED_END_DATE' | 'INDIVIDUAL_ANNIVERSARY' | 'NOT_RENEWABLE';

  @ApiProperty()
  @IsEnum(['PUBLISHED', 'RENEWAL_ONLY', 'UNPUBLISHED'])
  published: 'PUBLISHED' | 'RENEWAL_ONLY' | 'UNPUBLISHED';
}
