<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
use App\Models\Order;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =========================================================
    // RELACIONES
    // =========================================================

    /**
     * Obtiene los roles a los que pertenece el usuario (Many-to-Many).
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    // =========================================================
    // MÉTODOS DE CONVENIENCIA PARA ROLES
    // =========================================================
    
    /**
     * Verifica si el usuario tiene el rol de administrador.
     * Es el método que usa el Middleware 'CheckAdminRole'.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Usa una consulta eficiente: verifica la existencia de la relación con el slug 'admin'.
        // Esto evita cargar toda la colección de roles innecesariamente.
        return $this->roles()->where('slug', 'admin')->exists();
    }
    
    /**
     * Verifica si el usuario tiene un rol específico.
     *
     * @param string $slug Slug del rol (e.g., 'admin', 'user').
     * @return bool
     */
    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    /**
     * Verifica si el usuario tiene alguno de los roles dados.
     *
     * @param array<string> $slugs Array de slugs de roles.
     * @return bool
     */
    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles()->whereIn('slug', $slugs)->exists();
    }
    
}
