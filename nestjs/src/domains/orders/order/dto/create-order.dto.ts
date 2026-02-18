import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateOrderDto {
  @ApiPropertyOptional()
  @IsOptional()
  memberId?: any;

  @ApiProperty()
  @IsString()
  name: string;

  @ApiProperty()
  @IsString()
  email: string;

  @ApiProperty()
  @IsString()
  paymentMethod: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  paymentReference?: string;

  @ApiProperty()
  @IsEnum([
    'ORDER_PLACED',
    'PAYMENT_RECEIVED',
    'PAYMENT_PROBLEM',
    'CANCELLED',
    'CANCELLED_BEFORE_PAYMENT',
    'CANCELLED_PENDING_PAYMENT',
    'CANCELLED_REFUND_SCHEDULED',
    'CANCELLED_REFUND_DUE',
    'CANCELLED_NOT_REFUNDED',
    'CANCELLED_REFUNDED',
    'PARTIALLY_CANCELLED',
    'NO_PAYMENT_REQUIRED',
    'COMPLETED',
    'PARTIAL_PAYMENT',
    'REFUNDED',
    'PAYMENT_TRANSFER',
  ])
  orderStatus:
    | 'ORDER_PLACED'
    | 'PAYMENT_RECEIVED'
    | 'PAYMENT_PROBLEM'
    | 'CANCELLED'
    | 'CANCELLED_BEFORE_PAYMENT'
    | 'CANCELLED_PENDING_PAYMENT'
    | 'CANCELLED_REFUND_SCHEDULED'
    | 'CANCELLED_REFUND_DUE'
    | 'CANCELLED_NOT_REFUNDED'
    | 'CANCELLED_REFUNDED'
    | 'PARTIALLY_CANCELLED'
    | 'NO_PAYMENT_REQUIRED'
    | 'COMPLETED'
    | 'PARTIAL_PAYMENT'
    | 'REFUNDED'
    | 'PAYMENT_TRANSFER';

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  dateFinished: Date;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  comments?: string;

  @ApiProperty()
  @IsString()
  currencyCode: string;

  @ApiPropertyOptional()
  @IsOptional()
  currencyValue?: number;

  @ApiProperty()
  taxTotal: number;

  @ApiProperty()
  total: number;
}
