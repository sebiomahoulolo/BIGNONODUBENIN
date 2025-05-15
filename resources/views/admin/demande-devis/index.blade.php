@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Demande de devis</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                {{-- <a href="{{ route('admin.demande_devis.export') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Exporter
            </a> --}}
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
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
                                <th>Matérial</th>
                                <th>Catégory</th>
                                <th>Ville</th>
                                <th>Delai Livraison</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($demande_devis as $devis)
                                <tr>
                                    <td>{{ $devis->id }}</td>
                                    <td>{{ $devis->name }}</td>
                                    <td>{{ $devis->email }}</td>
                                    <td>{{ $devis->phone ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->material ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->category_name ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->ville ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->delai_livraison ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->description ?? 'Non renseigné' }}</td>
                                    <td>{{ $devis->created_at->format('d/m/Y H:i') }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td class=" text-center" colspan="10">Aucunes donnees</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $demande_devis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
