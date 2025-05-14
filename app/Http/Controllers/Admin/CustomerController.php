<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::withCount('orders')
            ->where('is_admin', false)
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['orders' => function($query) {
            $query->latest();
        }]);
        
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(User $customer)
    {
        if ($customer->orders()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce client car il a des commandes associées.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Client supprimé avec succès.');
    }

    public function export()
    {
        $customers = User::withCount('orders')
            ->where('is_admin', false)
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="clients.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // En-têtes du CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Téléphone',
                'Date d\'inscription',
                'Nombre de commandes',
                'Statut'
            ]);

            // Données des clients
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? 'Non renseigné',
                    $customer->created_at->format('d/m/Y H:i'),
                    $customer->orders_count,
                    $customer->is_active ? 'Actif' : 'Inactif'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
