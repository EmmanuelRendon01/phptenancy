<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controlador para gestionar Tenants desde la aplicación central
 */
class TenantController extends Controller
{
    /**
     * Muestra lista de todos los tenants
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();
        return view('central.tenants.index', compact('tenants'));
    }

    /**
     * Formulario para crear nuevo tenant
     */
    public function create()
    {
        return view('central.tenants.create');
    }

    /**
     * Guarda un nuevo tenant
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'subdomain' => 'required|string|max:63|alpha_dash|unique:domains,domain',
            'plan' => 'required|in:basic,pro,enterprise',
        ]);

        // Crear el tenant
        $tenant = Tenant::create([
            'id' => Str::slug($request->subdomain),
            'name' => $request->name,
            'email' => $request->email,
            'plan' => $request->plan,
        ]);

        // Crear el dominio (subdominio)
        $tenant->domains()->create([
            'domain' => $request->subdomain,
        ]);

        return redirect()->route('tenants.index')
            ->with('success', "Tenant '{$tenant->name}' creado exitosamente!");
    }

    /**
     * Muestra detalles de un tenant
     */
    public function show(Tenant $tenant)
    {
        $tenant->load('domains');
        return view('central.tenants.show', compact('tenant'));
    }

    /**
     * Formulario para editar tenant
     */
    public function edit(Tenant $tenant)
    {
        return view('central.tenants.edit', compact('tenant'));
    }

    /**
     * Actualiza un tenant
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'plan' => 'required|in:basic,pro,enterprise',
        ]);

        $tenant->update([
            'name' => $request->name,
            'email' => $request->email,
            'plan' => $request->plan,
        ]);

        return redirect()->route('tenants.index')
            ->with('success', "Tenant '{$tenant->name}' actualizado!");
    }

    /**
     * Elimina un tenant (y su base de datos)
     */
    public function destroy(Tenant $tenant)
    {
        $name = $tenant->name;
        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', "Tenant '{$name}' eliminado!");
    }
}
