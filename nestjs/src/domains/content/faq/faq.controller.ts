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
import { FaqService } from './faq.service';
import { CreateFaqDto, UpdateFaqDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('content')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('faqs')
export class FaqController {
  constructor(private readonly faqService: FaqService) {}

  @Get()
  @ApiOperation({ summary: 'Get all faqs' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.faqService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get faq by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.faqService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create faq' })
  create(@Body() dto: CreateFaqDto, @CurrentTenant() tenantId: number) {
    return this.faqService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update faq' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateFaqDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.faqService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete faq' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.faqService.remove(id, tenantId);
  }
}
