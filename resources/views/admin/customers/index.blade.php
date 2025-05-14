@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clients</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.customers.export') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Exporter
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'inscription</th>
                            <th>Commandes</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'Non renseigné' }}</td>
                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td>
                                <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                                    {{ $customer->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 