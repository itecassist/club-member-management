import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '@shared/prisma/prisma.service';
import { CreateArticleDto, UpdateArticleDto } from './dto';
import { PaginationDto, paginate } from '@shared/dto/pagination.dto';

@Injectable()
export class ArticleService {
  constructor(private prisma: PrismaService) {}

  async findAll(tenantId: number, pagination: PaginationDto) {
    const { page = 1, limit = 20, search, sortBy = 'id', sortOrder = 'desc' } = pagination;
    const skip = (page - 1) * limit;

    const where = {};

    const [items, total] = await Promise.all([
      this.prisma.article.findMany({
        where,
        skip,
        take: limit,
        orderBy: { [sortBy]: sortOrder },
      }),
      this.prisma.article.count({ where }),
    ]);

    return paginate(items, total, page, limit);
  }

  async findOne(id: number, tenantId: number) {
    const article = await this.prisma.article.findFirst({
      where: { id },
    });

    if (!article) {
      throw new NotFoundException('Article not found');
    }

    return article;
  }

  async create(dto: CreateArticleDto, tenantId: number) {
    return this.prisma.article.create({
      data: {
        ...dto,
      },
    });
  }

  async update(id: number, dto: UpdateArticleDto, tenantId: number) {
    await this.findOne(id, tenantId);

    return this.prisma.article.update({
      where: { id },
      data: dto,
    });
  }

  async remove(id: number, tenantId: number) {
    await this.findOne(id, tenantId);

    await this.prisma.article.delete({
      where: { id },
    });

    return { message: 'Article deleted successfully' };
  }
}
