<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Brand;
use App\Models\Permission;
use App\Models\RoleBrandPermission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin-builder');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('name', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Credenciales incorrectas'], 401);
    }

    public function getConfig()
    {
        $roles = Role::all();
        $brands = Brand::all();
        $permissions = Permission::all();

        // Build matrix: Role -> Brand -> [Permissions]
        $matrix = [];
        $rawPerms = RoleBrandPermission::with(['role', 'brand', 'permission'])->get();

        foreach ($rawPerms as $rp) {
            $roleSlug = $rp->role->slug;
            $brandSlug = $rp->brand->slug;
            $permSlug = $rp->permission->slug;

            if (!isset($matrix[$roleSlug])) {
                $matrix[$roleSlug] = [];
            }
            if (!isset($matrix[$roleSlug][$brandSlug])) {
                $matrix[$roleSlug][$brandSlug] = [];
            }
            $matrix[$roleSlug][$brandSlug][] = $permSlug;
        }

        return response()->json([
            'roles' => $roles,
            'brands' => $brands,
            'permissions' => $permissions,
            'matrix' => $matrix
        ]);
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        $slug = Str::slug($request->name);

        $role = Role::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json($role);
    }

    public function deleteRole(Request $request)
    {
        $request->validate(['slug' => 'required|exists:roles,slug']);
        $role = Role::where('slug', $request->slug)->first();

        // Cleanup relationships
        RoleBrandPermission::where('role_id', $role->id)->delete();
        $role->delete();

        return response()->json(['status' => 'success']);
    }

    public function storeBrand(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:brands,name']);
        $slug = Str::slug($request->name);

        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json($brand);
    }

    public function deleteBrand(Request $request)
    {
        $request->validate(['slug' => 'required|exists:brands,slug']);
        $brand = Brand::where('slug', $request->slug)->first();

        // Cleanup relationships
        RoleBrandPermission::where('brand_id', $brand->id)->delete();
        $brand->delete();

        return response()->json(['status' => 'success']);
    }

    public function saveMatrix(Request $request)
    {
        // Expects: role_slug, brand_slug, permissions (array of slugs)
        $request->validate([
            'role_slug' => 'required|exists:roles,slug',
            'brand_slug' => 'required|exists:brands,slug',
            'permissions' => 'present|array',
            'permissions.*' => 'exists:permissions,slug'
        ]);

        $role = Role::where('slug', $request->role_slug)->first();
        $brand = Brand::where('slug', $request->brand_slug)->first();

        // 1. Remove existing permissions for this Role+Brand
        RoleBrandPermission::where('role_id', $role->id)
            ->where('brand_id', $brand->id)
            ->delete();

        // 2. Add new permissions
        foreach ($request->permissions as $permSlug) {
            $perm = Permission::where('slug', $permSlug)->first();
            RoleBrandPermission::create([
                'role_id' => $role->id,
                'brand_id' => $brand->id,
                'permission_id' => $perm->id
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function deleteMatrix(Request $request)
    {
        $request->validate([
            'role_slug' => 'required|exists:roles,slug',
            'brand_slug' => 'required|exists:brands,slug',
        ]);

        $role = Role::where('slug', $request->role_slug)->first();
        $brand = Brand::where('slug', $request->brand_slug)->first();

        if ($role && $brand) {
            RoleBrandPermission::where('role_id', $role->id)
                ->where('brand_id', $brand->id)
                ->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
