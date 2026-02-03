<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
