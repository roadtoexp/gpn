<?php

declare(strict_types=1);

namespace App\Http\Models\Entity;

use App\Models\Entity\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Session extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id', 'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
