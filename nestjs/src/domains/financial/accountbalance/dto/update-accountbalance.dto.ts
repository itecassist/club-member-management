import { PartialType } from '@nestjs/swagger';
import { CreateAccountBalanceDto } from './create-accountbalance.dto';

export class UpdateAccountBalanceDto extends PartialType(CreateAccountBalanceDto) {}
