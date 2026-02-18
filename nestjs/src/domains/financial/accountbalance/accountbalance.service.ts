import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateAccountBalanceDto, UpdateAccountBalanceDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class AccountBalanceService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = { organisationId: tenantId };

    const [items, total] = await Promise.all([
      this.prisma.accountBalance.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.accountBalance.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const accountBalance = await this.prisma.accountBalance.findFirst({
      where: { id, organisationId: tenantId },
    });

    if (!accountBalance) {
      throw new NotFoundException('AccountBalance not found');
    }

    return accountBalance;
  }

  async create(dto: CreateAccountBalanceDto, tenantId: number) {
    return this.prisma.accountBalance.create({
      data: {
        ...dto,
        organisationId: tenantId,
      },
    });
  }

  async update(id: number, dto: UpdateAccountBalanceDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.accountBalance.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.accountBalance.delete({
      where: { id },
    });

    return { message: 'AccountBalance deleted successfully' };
  }
}
