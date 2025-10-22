<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hotel_id',
        'role_id',
    ];

    /**
     * Attributes hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ==========================
       🔗 RELATIONSHIPS
       ========================== */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /* ==========================
       🧠 ROLE HELPERS (Dynamic)
       ========================== */

    /**
     * Cek apakah user memiliki role dengan nama tertentu.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && strcasecmp($this->role->name, $roleName) === 0;
    }

    /**
     * Cek apakah role user bersifat global (akses penuh seluruh sistem).
     */
    public function isGlobalRole(): bool
    {
        return $this->role && $this->role->scope === 'global';
    }

    /**
     * Cek apakah role user bersifat hotel (akses terbatas per hotel).
     */
    public function isHotelRole(): bool
    {
        return $this->role && $this->role->scope === 'hotel';
    }

    /**
     * Ambil nama internal role user.
     */
    public function getRoleName(): ?string
    {
        return $this->role?->name;
    }

    public function isSuperAdmin(): bool
    {
        // Hanya user dengan nama role 'it_admin' (atau apapun nama super admin kamu)
        return $this->role && $this->role->name === 'super_admin';
    }

    /**
     * Ambil nama tampilan (display_name) role user.
     */
    public function getRoleLabel(): ?string
    {
        return $this->role?->display_name ?? $this->role?->name;
    }

    /* ==========================
       🔐 PERMISSION CHECKERS
       ========================== */

    /**
     * Cek apakah user memiliki permission tertentu.
     */
    public function hasPermission(string $key): bool
    {
        // Super admin: full access
        if ($this->isGlobalRole()) {
            return true;
        }

        // Cek relasi role → permissions → pivot.actions
        foreach ($this->role->permissions ?? [] as $perm) {
            $actions = explode(',', $perm->pivot->actions ?? '');
            if (in_array($key, $actions) || $perm->module . '_' . $key === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Alias agar lebih natural saat dipakai di Blade atau Controller.
     */
    public function canAccess(string $module, string $action = 'view'): bool
    {
        // ✅ Hanya beri full akses pada user dengan role `it_admin`
        if ($this->role && $this->role->name === 'super_admin') {
            return true;
        }

        // 🔗 Pastikan relasi role->permissions dimuat
        if (!$this->relationLoaded('role')) {
            $this->load('role.permissions');
        }

        $role = $this->role;
        if (!$role) return false;

        // 🔍 Cari permission untuk module yang cocok
        $permission = $role->permissions->firstWhere('module', $module);
        if (!$permission) return false;

        // 🎯 Ambil actions dari pivot
        $actions = explode(',', $permission->pivot->actions ?? '');

        return in_array($action, $actions);
    }
}
