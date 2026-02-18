import { Module } from '@nestjs/common';
import { AccountBalanceController } from './accountbalance/accountbalance.controller';
import { AccountBalanceService } from './accountbalance/accountbalance.service';

@Module({
  controllers: [AccountBalanceController],
  providers: [AccountBalanceService],
  exports: [AccountBalanceService],
})
export class AccountBalanceModule {}
