<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait MongoAppendsTrait
{
    protected $globalAppends = [
        'id', // Add global appendable attributes here, so it will appear in the json response
    ];

    protected function initializeHasGlobalAppends()
    {
        // Merge global appends with the model-specific appends
        $this->appends = array_unique(array_merge($this->appends, $this->globalAppends));
    }
}
