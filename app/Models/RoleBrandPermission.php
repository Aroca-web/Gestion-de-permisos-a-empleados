<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleBrandPermission extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'brand_id', 'permission_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
