import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateProductDto, UpdateProductDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class ProductService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = { organisationId: tenantId };

    const [items, total] = await Promise.all([
      this.prisma.product.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.product.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const product = await this.prisma.product.findFirst({
      where: { id, organisationId: tenantId },
    });

    if (!product) {
      throw new NotFoundException('Product not found');
    }

    return product;
  }

  async create(dto: CreateProductDto, tenantId: number) {
    return this.prisma.product.create({
      data: {
        ...dto,
        organisationId: tenantId,
      },
    });
  }

  async update(id: number, dto: UpdateProductDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.product.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.product.delete({
      where: { id },
    });

    return { message: 'Product deleted successfully' };
  }
}
