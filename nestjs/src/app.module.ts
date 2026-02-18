import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { PrismaModule } from './shared/prisma/prisma.module';
import { AuthModule } from './domains/auth/auth.module';
import { PermissionModule } from './domains/auth/permission.module';
import { RoleModule } from './domains/auth/role.module';
import { ArticleModule } from './domains/content/article.module';
import { FaqModule } from './domains/content/faq.module';
import { InvoiceModule } from './domains/financial/invoice.module';
import { PaymentModule } from './domains/financial/payment.module';
import { AccountBalanceModule } from './domains/financial/accountbalance.module';
import { VirtualFormModule } from './domains/forms/virtualform.module';
import { GroupModule } from './domains/groups/group.module';
import { MemberModule } from './domains/members/member.module';
import { OrderModule } from './domains/orders/order.module';
import { ProductModule } from './domains/products/product.module';
import { CountryModule } from './domains/shared/country.module';
import { SubscriptionModule } from './domains/subscriptions/subscription.module';
import { OrganisationModule } from './domains/tenancy/organisation.module';

@Module({
  imports: [
    ConfigModule.forRoot({
      isGlobal: true,
      envFilePath: '.env',
    }),
    PrismaModule,
    AuthModule,
    PermissionModule,
    RoleModule,
    ArticleModule,
    FaqModule,
    InvoiceModule,
    PaymentModule,
    AccountBalanceModule,
    VirtualFormModule,
    GroupModule,
    MemberModule,
    OrderModule,
    ProductModule,
    CountryModule,
    SubscriptionModule,
    OrganisationModule,
  ],
})
export class AppModule {}
