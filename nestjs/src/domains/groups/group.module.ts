import { Module } from '@nestjs/common';
import { GroupController } from './group/group.controller';
import { GroupService } from './group/group.service';

@Module({
  controllers: [GroupController],
  providers: [GroupService],
  exports: [GroupService],
})
export class GroupModule {}
