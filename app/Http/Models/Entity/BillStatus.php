<?php

declare(strict_types=1);

namespace App\Http\Models\Entity;

use Illuminate\Database\Eloquent\Model;

class BillStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id', 'value',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;
}
