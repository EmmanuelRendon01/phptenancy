<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Category para gestión de categorías de productos
 * Este modelo pertenece al contexto del tenant
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * Casteo de atributos
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación: Una categoría tiene muchos productos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope: Solo categorías activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Obtener el conteo de productos en esta categoría
     */
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
}
