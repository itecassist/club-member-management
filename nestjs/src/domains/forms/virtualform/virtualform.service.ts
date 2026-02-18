import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateVirtualFormDto, UpdateVirtualFormDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class VirtualFormService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = { organisationId: tenantId };

    const [items, total] = await Promise.all([
      this.prisma.virtualForm.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.virtualForm.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const virtualform = await this.prisma.virtualForm.findFirst({
      where: { id, organisationId: tenantId },
    });

    if (!virtualform) {
      throw new NotFoundException('VirtualForm not found');
    }

    return virtualform;
  }

  async create(dto: CreateVirtualFormDto, tenantId: number) {
    return this.prisma.virtualForm.create({
      data: {
        ...dto,
        organisationId: tenantId,
      },
    });
  }

  async update(id: number, dto: UpdateVirtualFormDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.virtualForm.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.virtualForm.delete({
      where: { id },
    });

    return { message: 'VirtualForm deleted successfully' };
  }
}
