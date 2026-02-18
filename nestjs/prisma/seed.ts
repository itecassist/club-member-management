import { PrismaClient } from '@prisma/client';
import * as bcrypt from 'bcrypt';

const prisma = new PrismaClient();

async function main() {
  console.log('🌱 Seeding database...');

  // Create test organization
  const org = await prisma.organisation.upsert({
    where: { seoName: 'test-org' },
    update: {},
    create: {
      name: 'Test Organization',
      seoName: 'test-org',
      email: 'admin@testorg.com',
      phone: '+1234567890',
      freeTrail: true,
      freeTrailEndDate: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000), // 30 days from now
      billingPolicy: 'DEBIT_ORDER',
      isActive: true,
    },
  });

  console.log('✓ Created organization:', org.name);

  // Create test user
  const hashedPassword = await bcrypt.hash('password123', 10);

  const user = await prisma.user.upsert({
    where: { email: 'admin@testorg.com' },
    update: {},
    create: {
      email: 'admin@testorg.com',
      password: hashedPassword,
      name: 'Admin User',
      organisationId: org.id,
      isActive: true,
    },
  });

  console.log('✓ Created user:', user.email);

  // Create test member
  const member = await prisma.member.upsert({
    where: { id: 1 },
    update: {},
    create: {
      userId: user.id,
      organisationId: org.id,
      firstName: 'John',
      lastName: 'Doe',
      email: 'john.doe@example.com',
      mobilePhone: '+1234567890',
      gender: 'MALE',
      joinedAt: new Date(),
      lastLoginAt: new Date(),
      roles: {},
      isActive: true,
    },
  });

  console.log('✓ Created member:', `${member.firstName} ${member.lastName}`);

  console.log('\n✨ Seeding complete!');
  console.log('\n📝 Test credentials:');
  console.log('   Email: admin@testorg.com');
  console.log('   Password: password123');
}

main()
  .catch((e) => {
    console.error('Error seeding database:', e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
