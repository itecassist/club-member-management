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
import { SubscriptionService } from './subscription.service';
import { CreateSubscriptionDto, UpdateSubscriptionDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('subscriptions')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('subscriptions')
export class SubscriptionController {
  constructor(private readonly subscriptionService: SubscriptionService) {}

  @Get()
  @ApiOperation({ summary: 'Get all subscriptions' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.subscriptionService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get subscription by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.subscriptionService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create subscription' })
  create(@Body() dto: CreateSubscriptionDto, @CurrentTenant() tenantId: number) {
    return this.subscriptionService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update subscription' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateSubscriptionDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.subscriptionService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete subscription' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.subscriptionService.remove(id, tenantId);
  }
}
