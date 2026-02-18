import { Module } from '@nestjs/common';
import { OrganisationController } from './organisation/organisation.controller';
import { OrganisationService } from './organisation/organisation.service';

@Module({
  controllers: [OrganisationController],
  providers: [OrganisationService],
  exports: [OrganisationService],
})
export class OrganisationModule {}
