<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BaseModel extends Model
{
    public function scopeFilterSort($query, $filters)
    {
        return $query->when(!empty($filters['sort']['field']), function ($q) use ($filters) {
            $q->orderBy($filters['sort']['field'], $filters['sort']['direction']);
        });
    }
}
