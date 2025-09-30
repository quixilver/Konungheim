<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'symbol_svg',
    ];

    /**
     * The characters that have this perk.
     */
    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_perk');
    }

    /**
     * The roles that include this perk.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_perk');
    }
}