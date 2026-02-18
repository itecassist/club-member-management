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
import { OrderService } from './order.service';
import { CreateOrderDto, UpdateOrderDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('orders')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('orders')
export class OrderController {
  constructor(private readonly orderService: OrderService) {}

  @Get()
  @ApiOperation({ summary: 'Get all orders' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.orderService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get order by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.orderService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create order' })
  create(@Body() dto: CreateOrderDto, @CurrentTenant() tenantId: number) {
    return this.orderService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update order' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateOrderDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.orderService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete order' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.orderService.remove(id, tenantId);
  }
}
