import { Injectable, UnauthorizedException, ConflictException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { PrismaService } from '@shared/prisma/prisma.service';
import * as bcrypt from 'bcrypt';
import { LoginDto, RegisterDto } from './dto';

@Injectable()
export class AuthService {
  constructor(
    private prisma: PrismaService,
    private jwtService: JwtService,
  ) {}

  async register(dto: RegisterDto) {
    // Check if user exists
    const existingUser = await this.prisma.user.findUnique({
      where: { email: dto.email },
    });

    if (existingUser) {
      throw new ConflictException('User with this email already exists');
    }

    // Hash password
    const hashedPassword = await bcrypt.hash(dto.password, 10);

    // Create user
    const user = await this.prisma.user.create({
      data: {
        email: dto.email,
        password: hashedPassword,
        name: `${dto.firstName || ''} ${dto.lastName || ''}`.trim() || dto.email,
        organisationId: BigInt(dto.organisationId),
      },
    });

    // Generate token
    const token = await this.generateToken(user);

    return {
      user: this.sanitizeUser(user),
      token,
    };
  }

  async login(dto: LoginDto) {
    // Find user
    const user = await this.prisma.user.findUnique({
      where: { email: dto.email },
      include: {
        organisation: true,
      },
    });

    if (!user) {
      throw new UnauthorizedException('Invalid credentials');
    }

    // Verify password
    const isPasswordValid = await bcrypt.compare(dto.password, user.password);

    if (!isPasswordValid) {
      throw new UnauthorizedException('Invalid credentials');
    }

    // Update last login
    await this.prisma.user.update({
      where: { id: user.id },
      data: { lastLoginAt: new Date() },
    });

    // Generate token
    const token = await this.generateToken(user);

    return {
      user: this.sanitizeUser(user),
      organisation: user.organisation,
      token,
    };
  }

  async validateUser(userId: number) {
    const user = await this.prisma.user.findUnique({
      where: { id: userId },
      include: {
        organisation: true,
      },
    });

    if (!user) {
      throw new UnauthorizedException('User not found');
    }

    return this.sanitizeUser(user);
  }

  private async generateToken(user: any) {
    const payload = {
      sub: Number(user.id),
      email: user.email,
      organisationId: user.organisationId ? Number(user.organisationId) : null,
    };

    return {
      accessToken: this.jwtService.sign(payload),
      expiresIn: '1d',
    };
  }

  private sanitizeUser(user: any) {
    const { password, ...rest } = user;
    // Convert BigInt fields to numbers for JSON serialization
    return {
      ...rest,
      id: Number(rest.id),
      organisationId: rest.organisationId ? Number(rest.organisationId) : null,
      organisation: rest.organisation
        ? {
            ...rest.organisation,
            id: Number(rest.organisation.id),
          }
        : undefined,
    };
  }
}
