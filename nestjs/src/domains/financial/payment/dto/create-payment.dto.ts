import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreatePaymentDto {
  @ApiProperty()
  memberId: any;

  @ApiPropertyOptional()
  @IsOptional()
  invoiceId?: any;

  @ApiProperty()
  @Type(() => Date)
  @IsDate()
  paymentDate: Date;

  @ApiProperty()
  amount: number;

  @ApiProperty()
  @IsString()
  paymentMethod: string;

  @ApiPropertyOptional()
  @IsOptional()
  @IsString()
  reference?: string;

  @ApiProperty()
  @IsEnum(['PENDING', 'COMPLETED', 'FAILED', 'REFUNDED'])
  status: 'PENDING' | 'COMPLETED' | 'FAILED' | 'REFUNDED';
}
