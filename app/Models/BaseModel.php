<?php

namespace App\Models;

//MYSQL use this
use App\Models\Model;
//MongoDB use this
// use App\Traits\MongoAppendsTrait;
// use Moloquent;


class BaseModel extends Model #Model(MySQL) or Moloquent(MONGO) 
{
    public function scopeFilterSort($query, $filters)
    {
        return $query->when(!empty($filters['sort']['field']), function ($q) use ($filters) {
            $q->orderBy($filters['sort']['field'], $filters['sort']['direction']);
        });
    }


    /**
     * Bottom is Mongodb related functions, hide this if using MySQL
     */
    // use MongoAppendsTrait;

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);

    //     // Initialize the trait
    //     $this->initializeHasGlobalAppends();
    // }
}
