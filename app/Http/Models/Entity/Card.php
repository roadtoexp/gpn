<?php

declare(strict_types=1);

namespace App\Http\Models\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id', 'bill_id', 'type_id', 'number', 'active', 'balance', 'last_usage', 'description',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'bill_id', 'type_id',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    public function type(): HasOne
    {
        return $this->hasOne(CardType::class, 'id', 'status_id');
    }

    public function bill(): HasOne
    {
        return $this->hasOne(Bill::class, 'id', 'bill_id');
    }
}
