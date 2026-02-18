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
import { OrganisationService } from './organisation.service';
import { CreateOrganisationDto, UpdateOrganisationDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('tenancy')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('organisations')
export class OrganisationController {
  constructor(private readonly organisationService: OrganisationService) {}

  @Get()
  @ApiOperation({ summary: 'Get all organisations' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.organisationService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get organisation by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.organisationService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create organisation' })
  create(@Body() dto: CreateOrganisationDto, @CurrentTenant() tenantId: number) {
    return this.organisationService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update organisation' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateOrganisationDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.organisationService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete organisation' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.organisationService.remove(id, tenantId);
  }
}
