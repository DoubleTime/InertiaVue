<?php

namespace App\Models;

//MYSQL use this
//use App\Models\Model;
//MongoDB use this
use Moloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BaseModel extends Moloquent
{
    public function scopeFilterSort($query, $filters)
    {
        return $query->when(!empty($filters['sort']['field']), function ($q) use ($filters) {
            $q->orderBy($filters['sort']['field'], $filters['sort']['direction']);
        });
    }
}
