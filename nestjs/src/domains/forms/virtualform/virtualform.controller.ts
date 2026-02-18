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
import { VirtualFormService } from './virtualform.service';
import { CreateVirtualFormDto, UpdateVirtualFormDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('forms')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('virtualforms')
export class VirtualFormController {
  constructor(private readonly virtualformService: VirtualFormService) {}

  @Get()
  @ApiOperation({ summary: 'Get all virtualforms' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.virtualformService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get virtualform by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.virtualformService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create virtualform' })
  create(@Body() dto: CreateVirtualFormDto, @CurrentTenant() tenantId: number) {
    return this.virtualformService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update virtualform' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateVirtualFormDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.virtualformService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete virtualform' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.virtualformService.remove(id, tenantId);
  }
}
