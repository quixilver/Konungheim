<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'symbol_svg',
    ];

    /**
     * The characters that belong to the role.
     */
    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_role');
    }

    /**
     * The perks included in this role.
     */
    public function perksIncluded()
    {
        return $this->belongsToMany(Perk::class, 'role_perk');
    }
}