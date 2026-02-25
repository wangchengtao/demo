<?php

declare(strict_types=1);

namespace App\Models;

use EloquentFilter\Filterable;

class Category extends Model
{
    use Filterable;

    protected $fillable = [
        'name', 'order',
    ];
}
