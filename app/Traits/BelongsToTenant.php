<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                // Jika super admin, jangan batasi tenant
                if (auth()->user()->is_super_admin) {
                    return;
                }

                // Kalau bukan super admin, filter tenant
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && !auth()->user()->is_super_admin) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}
