import { Module } from '@nestjs/common';
import { VirtualFormController } from './virtualform/virtualform.controller';
import { VirtualFormService } from './virtualform/virtualform.service';

@Module({
  controllers: [VirtualFormController],
  providers: [VirtualFormService],
  exports: [VirtualFormService],
})
export class VirtualFormModule {}
