import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateInvoiceDto {
  @ApiProperty()
  memberId: any;

  @ApiProperty()
  @IsString()
  invoiceNumber: string;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  issueDate: Date;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  dueDate: Date;

  @ApiProperty()
  @IsEnum(['DRAFT', 'SENT', 'PAID', 'OVERDUE', 'CANCELLED'])
  status: 'DRAFT' | 'SENT' | 'PAID' | 'OVERDUE' | 'CANCELLED';

  @ApiProperty()
  subtotal: number;

  @ApiProperty()
  taxTotal: number;

  @ApiProperty()
  total: number;

  @ApiProperty()
  @IsString()
  currencyCode: string;
}
