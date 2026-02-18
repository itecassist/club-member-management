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
import { AccountBalanceService } from './accountbalance.service';
import { CreateAccountBalanceDto, UpdateAccountBalanceDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('financial')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('accountbalances')
export class AccountBalanceController {
  constructor(private readonly accountbalanceService: AccountBalanceService) {}

  @Get()
  @ApiOperation({ summary: 'Get all accountbalances' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.accountbalanceService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get accountbalance by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.accountbalanceService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create accountbalance' })
  create(@Body() dto: CreateAccountBalanceDto, @CurrentTenant() tenantId: number) {
    return this.accountbalanceService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update accountbalance' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateAccountBalanceDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.accountbalanceService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete accountbalance' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.accountbalanceService.remove(id, tenantId);
  }
}
