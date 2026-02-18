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
import { CountryService } from './country.service';
import { CreateCountryDto, UpdateCountryDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('shared')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('countrys')
export class CountryController {
  constructor(private readonly countryService: CountryService) {}

  @Get()
  @ApiOperation({ summary: 'Get all countrys' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.countryService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get country by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.countryService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create country' })
  create(@Body() dto: CreateCountryDto, @CurrentTenant() tenantId: number) {
    return this.countryService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update country' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateCountryDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.countryService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete country' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.countryService.remove(id, tenantId);
  }
}
