import { Injectable, UnauthorizedException } from '@nestjs/common';
import { PassportStrategy } from '@nestjs/passport';
import { ExtractJwt, Strategy } from 'passport-jwt';
import { ConfigService } from '@nestjs/config';
import { PrismaService } from '@shared/prisma/prisma.service';

export interface JwtPayload {
  sub: number;
  email: string;
  organisationId: number;
}

@Injectable()
export class JwtStrategy extends PassportStrategy(Strategy) {
  constructor(
    private configService: ConfigService,
    private prisma: PrismaService,
  ) {
    super({
      jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
      ignoreExpiration: false,
      secretOrKey: configService.get<string>('JWT_SECRET'),
    });
  }

  async validate(payload: JwtPayload) {
    const user = await this.prisma.user.findUnique({
      where: { id: payload.sub },
      include: {
        organisation: true,
      },
    });

    if (!user) {
      throw new UnauthorizedException();
    }

    return {
      id: Number(user.id),
      email: user.email,
      name: user.name,
      organisationId: user.organisationId ? Number(user.organisationId) : null,
      organisation: user.organisation
        ? {
            ...user.organisation,
            id: Number(user.organisation.id),
          }
        : null,
    };
  }
}
