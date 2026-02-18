import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateFaqDto, UpdateFaqDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class FaqService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = {};

    const [items, total] = await Promise.all([
      this.prisma.faq.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.faq.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const faq = await this.prisma.faq.findFirst({
      where: { id },
    });

    if (!faq) {
      throw new NotFoundException('Faq not found');
    }

    return faq;
  }

  async create(dto: CreateFaqDto, tenantId: number) {
    return this.prisma.faq.create({
      data: {
        ...dto,
      },
    });
  }

  async update(id: number, dto: UpdateFaqDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.faq.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.faq.delete({
      where: { id },
    });

    return { message: 'Faq deleted successfully' };
  }
}
