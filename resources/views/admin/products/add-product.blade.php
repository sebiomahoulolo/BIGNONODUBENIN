@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ajouter un nouveau produit</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="nombre_places">Nombre de places</label>
                            <input type="text" class="form-control @error('nombre_places') is-invalid @enderror" 
                                   id="nombre_places" name="nombre_places" value="{{ old('nombre_places') }}" required>
                            @error('nombre_places')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="matiere">Matière utilisée</label>
                            <input type="text" class="form-control @error('matiere') is-invalid @enderror" 
                                   id="matiere" name="matiere" value="{{ old('matiere') }}" required>
                            @error('matiere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">Prix</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="sale_price">Prix promotionnel (optionnel)</label>
                            <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" 
                                   id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" min="0" step="1" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', '0') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="category_id">Catégorie</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="images">Images (2-8 images requises)</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   id="images" name="images[]" multiple accept="image/*" required>
                            <small class="form-text text-muted">Sélectionnez entre 2 et 8 images. Formats acceptés : JPG, JPEG, PNG, GIF. Taille maximale : 2MB par image.</small>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Ajouter le produit</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addProductForm');
    const imageInput = document.getElementById('images');
    const submitButton = form.querySelector('button[type="submit"]');
    const stockInput = document.getElementById('stock');

    // Validation des images
    imageInput.addEventListener('change', function() {
        const files = this.files;
        if (files.length < 2 || files.length > 8) {
            alert('Veuillez sélectionner entre 2 et 8 images.');
            this.value = '';
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    });

    // Gestion du stock
    stockInput.addEventListener('input', function() {
        // Supprime les zéros au début
        let value = this.value.replace(/^0+/, '');
        // Si la valeur est vide, met 0
        if (value === '') value = '0';
        // Met à jour la valeur
        this.value = value;
    });

    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        const stock = parseInt(stockInput.value) || 0;
        const price = parseFloat(document.getElementById('price').value) || 0;
        const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;

        // Vérification que le stock est un nombre entier positif
        if (stock < 0) {
            e.preventDefault();
            alert('Le stock doit être un nombre entier positif.');
            return;
        }

        // Vérification que le prix est un nombre positif
        if (price <= 0) {
            e.preventDefault();
            alert('Le prix doit être un nombre positif.');
            return;
        }

        // Vérification que le prix promotionnel est inférieur au prix normal
        if (salePrice > 0 && salePrice >= price) {
            e.preventDefault();
            alert('Le prix promotionnel doit être inférieur au prix normal.');
            return;
        }
    });
});
</script>
@endpush
@endsection 