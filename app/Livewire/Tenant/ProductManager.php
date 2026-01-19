<?php

namespace App\Livewire\Tenant;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public $name;
    public $description;
    public $sku;
    public $price;
    public $stock = 0;
    public $category_id;
    public $image;
    public $is_active = true;
    public $productId;
    public $isEditing = false;
    public $search = '';
    public $filterCategory = '';
    public $filterStock = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sku' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterStock === 'in_stock', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($this->filterStock === 'out_of_stock', function ($query) {
                $query->where('stock', '<=', 0);
            })
            ->latest()
            ->paginate(10);

        $categories = Category::active()->get();

        return view('livewire.tenant.product-manager', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
        ];

        // Manejar la imagen si se subió una nueva
        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        if ($this->isEditing) {
            $product = Product::find($this->productId);
            $product->update($data);
            session()->flash('message', 'Producto actualizado exitosamente.');
        } else {
            Product::create($data);
            session()->flash('message', 'Producto creado exitosamente.');
        }

        $this->reset(['name', 'description', 'sku', 'price', 'stock', 'category_id', 'image', 'is_active', 'productId', 'isEditing']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->sku = $product->sku;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->is_active = $product->is_active;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Eliminar imagen si existe
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        session()->flash('message', 'Producto eliminado exitosamente.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'sku', 'price', 'stock', 'category_id', 'image', 'is_active', 'productId', 'isEditing']);
    }

    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
    }

    public function adjustStock($id, $quantity)
    {
        $product = Product::findOrFail($id);
        $product->update(['stock' => max(0, $product->stock + $quantity)]);
        session()->flash('message', 'Stock actualizado.');
    }
}
