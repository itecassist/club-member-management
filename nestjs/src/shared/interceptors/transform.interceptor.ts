import {
  Injectable,
  NestInterceptor,
  ExecutionContext,
  CallHandler,
  HttpStatus,
} from '@nestjs/common';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

export interface Response<T> {
  statusCode: number;
  message?: string;
  data: T;
  meta?: any;
}

@Injectable()
export class TransformInterceptor<T> implements NestInterceptor<T, Response<T>> {
  intercept(context: ExecutionContext, next: CallHandler): Observable<Response<T>> {
    return next.handle().pipe(
      map((data) => {
        const response = context.switchToHttp().getResponse();
        const statusCode = response.statusCode || HttpStatus.OK;

        // If data already has the structure, return as is
        if (data && typeof data === 'object' && 'statusCode' in data) {
          return data;
        }

        // Check if paginated response
        if (data && typeof data === 'object' && 'items' in data && 'meta' in data) {
          return {
            statusCode,
            data: data.items,
            meta: data.meta,
          };
        }

        return {
          statusCode,
          data,
        };
      }),
    );
  }
}
