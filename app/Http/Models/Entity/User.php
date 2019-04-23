<?php

declare(strict_types=1);

namespace App\Models\Entity;

use App\Http\Models\Entity\Bill;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'user_id', 'id');
    }
}
