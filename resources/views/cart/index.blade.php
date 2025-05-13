@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Mon Panier</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count(session('cart', [])) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('cart') as $id => $details)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="img-thumbnail me-3" style="width: 100px;">
                                    @endif
                                    <div>
                                        <h5 class="mb-0">{{ $details['name'] }}</h5>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($details['price'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control form-control-sm" style="width: 70px;" min="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ number_format($details['price'] * $details['quantity'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Vider le panier
                </button>
            </form>
            <a href="{{ route('checkout') }}" class="btn btn-primary">
                <i class="bi bi-credit-card"></i> Passer la commande
            </a>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h3 class="mt-3">Votre panier est vide</h3>
            <p class="text-muted">Découvrez nos produits et commencez vos achats</p>
            <a href="{{ route('pages.products') }}" class="btn btn-primary mt-3">
                Voir les produits
            </a>
        </div>
    @endif
</div>
@endsection 