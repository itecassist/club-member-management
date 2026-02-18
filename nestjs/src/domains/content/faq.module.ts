import { Module } from '@nestjs/common';
import { FaqController } from './faq/faq.controller';
import { FaqService } from './faq/faq.service';

@Module({
  controllers: [FaqController],
  providers: [FaqService],
  exports: [FaqService],
})
export class FaqModule {}
