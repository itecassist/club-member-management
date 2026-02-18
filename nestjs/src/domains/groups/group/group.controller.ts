import {
  Controller,
  Get,
  Post,
  Put,
  Delete,
  Body,
  Param,
  Query,
  UseGuards,
  ParseIntPipe,
} from '@nestjs/common';
import { ApiTags, ApiOperation, ApiBearerAuth } from '@nestjs/swagger';
import { GroupService } from './group.service';
import { CreateGroupDto, UpdateGroupDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('groups')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('groups')
export class GroupController {
  constructor(private readonly groupService: GroupService) {}

  @Get()
  @ApiOperation({ summary: 'Get all groups' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.groupService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get group by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.groupService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create group' })
  create(@Body() dto: CreateGroupDto, @CurrentTenant() tenantId: number) {
    return this.groupService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update group' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateGroupDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.groupService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete group' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.groupService.remove(id, tenantId);
  }
}
