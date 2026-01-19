<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Product para gestión de productos del inventario
 * Este modelo pertenece al contexto del tenant
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'stock',
        'category_id',
        'image',
        'is_active',
    ];

    /**
     * Casteo de atributos
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope: Solo productos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Productos con stock disponible
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope: Productos sin stock
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Verificar si el producto tiene stock
     */
    public function hasStock()
    {
        return $this->stock > 0;
    }

    /**
     * Decrementar stock
     */
    public function decrementStock($quantity = 1)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Incrementar stock
     */
    public function incrementStock($quantity = 1)
    {
        $this->increment('stock', $quantity);
    }

    /**
     * Obtener el estado del stock
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= 10) {
            return 'low_stock';
        }
        return 'in_stock';
    }
}
