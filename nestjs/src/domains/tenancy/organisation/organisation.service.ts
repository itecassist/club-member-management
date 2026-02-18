import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateOrganisationDto, UpdateOrganisationDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class OrganisationService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = {};

    const [items, total] = await Promise.all([
      this.prisma.organisation.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.organisation.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const organisation = await this.prisma.organisation.findFirst({
      where: { id },
    });

    if (!organisation) {
      throw new NotFoundException('Organisation not found');
    }

    return organisation;
  }

  async create(dto: CreateOrganisationDto, tenantId: number) {
    return this.prisma.organisation.create({
      data: {
        ...dto,
      },
    });
  }

  async update(id: number, dto: UpdateOrganisationDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.organisation.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.organisation.delete({
      where: { id },
    });

    return { message: 'Organisation deleted successfully' };
  }
}
