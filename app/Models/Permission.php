<?php

namespace App\Models;

use App\Helpers\Collections\PermissionCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use HasFactory;

    public function newCollection(array $models = [])
    {
        return new PermissionCollection($models);
    }

    public function scopeGuard(Builder $q, $guard = null): void
    {

        $q->when($guard != null, function (Builder $builder) use ($guard) {

            $builder->where('guard_name', $guard);

        });
    }
}
