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
import { MemberService } from './member.service';
import { CreateMemberDto, UpdateMemberDto } from './dto';
import { PaginationDto } from '@shared/dto/pagination.dto';
import { JwtAuthGuard, TenantGuard } from '@shared/guards';
import { CurrentTenant } from '@shared/decorators';

@ApiTags('members')
@ApiBearerAuth()
@UseGuards(JwtAuthGuard, TenantGuard)
@Controller('members')
export class MemberController {
  constructor(private readonly memberService: MemberService) {}

  @Get()
  @ApiOperation({ summary: 'Get all members' })
  findAll(@Query() pagination: PaginationDto, @CurrentTenant() tenantId: number) {
    return this.memberService.findAll(tenantId, pagination);
  }

  @Get(':id')
  @ApiOperation({ summary: 'Get member by ID' })
  findOne(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.memberService.findOne(id, tenantId);
  }

  @Post()
  @ApiOperation({ summary: 'Create member' })
  create(@Body() dto: CreateMemberDto, @CurrentTenant() tenantId: number) {
    return this.memberService.create(dto, tenantId);
  }

  @Put(':id')
  @ApiOperation({ summary: 'Update member' })
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateMemberDto,
    @CurrentTenant() tenantId: number,
  ) {
    return this.memberService.update(id, dto, tenantId);
  }

  @Delete(':id')
  @ApiOperation({ summary: 'Delete member' })
  remove(@Param('id', ParseIntPipe) id: number, @CurrentTenant() tenantId: number) {
    return this.memberService.remove(id, tenantId);
  }
}
