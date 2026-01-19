<?php

namespace App\Livewire\Tenant;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryManager extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $is_active = true;
    public $categoryId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return view('livewire.tenant.category-manager', [
            'categories' => $categories,
        ]);
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $category = Category::find($this->categoryId);
            $category->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Categoría actualizada exitosamente.');
        } else {
            Category::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Categoría creada exitosamente.');
        }

        $this->reset(['name', 'description', 'is_active', 'categoryId', 'isEditing']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            session()->flash('error', 'No se puede eliminar una categoría con productos asociados.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Categoría eliminada exitosamente.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'is_active', 'categoryId', 'isEditing']);
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);
    }
}
