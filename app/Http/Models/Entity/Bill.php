<?php

declare(strict_types=1);

namespace App\Http\Models\Entity;

use App\Models\Entity\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bill extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id', 'user_id', 'number', 'status_id',
    ];

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'status',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'user_id', 'status_id',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    public function status(): HasOne
    {
        return $this->hasOne(BillStatus::class, 'id', 'status_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getStatusAttribute()
    {
        return $this->status = $this->status_id;
    }
}
