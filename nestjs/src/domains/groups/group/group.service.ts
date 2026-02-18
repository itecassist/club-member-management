import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateGroupDto, UpdateGroupDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class GroupService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = { organisationId: tenantId };

    const [items, total] = await Promise.all([
      this.prisma.group.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.group.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const group = await this.prisma.group.findFirst({
      where: { id, organisationId: tenantId },
    });

    if (!group) {
      throw new NotFoundException('Group not found');
    }

    return group;
  }

  async create(dto: CreateGroupDto, tenantId: number) {
    return this.prisma.group.create({
      data: {
        ...dto,
        organisationId: tenantId,
      },
    });
  }

  async update(id: number, dto: UpdateGroupDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.group.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.group.delete({
      where: { id },
    });

    return { message: 'Group deleted successfully' };
  }
}
