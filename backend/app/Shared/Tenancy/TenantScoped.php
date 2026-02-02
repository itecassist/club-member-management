<?php

namespace App\Shared\Tenancy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (
                Auth::check() &&
                Schema::hasColumn($builder->getModel()->getTable(), 'organisation_id')
            ) {
                $builder->where(
                    $builder->getModel()->getTable().'.organisation_id',
                    Auth::user()->active_organisation_id
                );
            }
        });

        static::creating(function ($model) {
            if (
                Auth::check() &&
                Schema::hasColumn($model->getTable(), 'organisation_id')
            ) {
                $model->organisation_id = Auth::user()->active_organisation_id;
            }
        });
    }
}
