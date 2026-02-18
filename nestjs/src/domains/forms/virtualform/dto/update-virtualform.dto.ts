import { PartialType } from '@nestjs/swagger';
import { CreateVirtualFormDto } from './create-virtualform.dto';

export class UpdateVirtualFormDto extends PartialType(CreateVirtualFormDto) {}
