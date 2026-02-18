import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { IsString, IsInt, IsBoolean, IsOptional, IsEmail, IsEnum, IsDate } from 'class-validator';
import { Type } from 'class-transformer';

export class CreateAccountBalanceDto {
  @ApiProperty()
  @IsString()
  holderType: string;

  @ApiProperty()
  holderId: any;

  @ApiProperty()
  balance: number;

  @ApiProperty()
  @IsString()
  currencyCode: string;

  @ApiPropertyOptional()
  @IsOptional()
  @Type(() => Date)
  @IsDate()
  lastTransactionAt?: Date;

}
