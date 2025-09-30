<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'seed',
        'description',
        'traits',
    ];

    protected $casts = [
        'traits' => 'array',
    ];

    /**
     * Get the characters currently in this world.
     */
    public function characters()
    {
        return $this->hasMany(Character::class, 'world_current');
    }
}