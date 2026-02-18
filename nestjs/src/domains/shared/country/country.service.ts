import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateCountryDto, UpdateCountryDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class CountryService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = {};

    const [items, total] = await Promise.all([
      this.prisma.country.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.country.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const country = await this.prisma.country.findFirst({
      where: { id },
    });

    if (!country) {
      throw new NotFoundException('Country not found');
    }

    return country;
  }

  async create(dto: CreateCountryDto, tenantId: number) {
    return this.prisma.country.create({
      data: {
        ...dto,
      },
    });
  }

  async update(id: number, dto: UpdateCountryDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.country.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.country.delete({
      where: { id },
    });

    return { message: 'Country deleted successfully' };
  }
}
