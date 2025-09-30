<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'picture',
        'weapons',
        'objective',
        'world_current',
        'user_owner',
    ];

    protected $casts = [
        'weapons' => 'array',
    ];

    /**
     * Get the user that owns the character.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_owner');
    }

    /**
     * Get the world the character is currently in.
     */
    public function world()
    {
        return $this->belongsTo(World::class, 'world_current');
    }

    /**
     * The roles that belong to the character.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'character_role');
    }

    /**
     * The perks that belong to the character.
     */
    public function perks()
    {
        return $this->belongsToMany(Perk::class, 'character_perk');
    }
}