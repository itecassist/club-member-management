import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateOrderDto, UpdateOrderDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class OrderService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = { organisationId: tenantId };

    const [items, total] = await Promise.all([
      this.prisma.order.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.order.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const order = await this.prisma.order.findFirst({
      where: { id, organisationId: tenantId },
    });

    if (!order) {
      throw new NotFoundException('Order not found');
    }

    return order;
  }

  async create(dto: CreateOrderDto, tenantId: number) {
    return this.prisma.order.create({
      data: {
        ...dto,
        organisationId: tenantId,
      },
    });
  }

  async update(id: number, dto: UpdateOrderDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.order.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.order.delete({
      where: { id },
    });

    return { message: 'Order deleted successfully' };
  }
}
