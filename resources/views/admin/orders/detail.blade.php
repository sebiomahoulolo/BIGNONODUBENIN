@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Commandes</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.orders.export') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i> Exporter
                </a>
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

        <div class="container">
            <div class="row shadow-lg rounded-3 py-3 fs-1 mb-2 bg-primary text-center d-flex justify-content-center fw-bold text-white"> N° Commande: {{ $order->order_number }} </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%"  cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItem as $item)
                                <tr>
                                    <td><img src="{{ $item->image_path }}" alt=""></td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
