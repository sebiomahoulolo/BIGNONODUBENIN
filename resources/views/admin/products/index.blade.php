{{-- Message de confirmation Laravel --}}
@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

{{-- Message d’erreur si besoin --}}
@if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif


@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestion des Produits</h1>
        <form action="{{ route('newsletter.sendLatest') }}" method="GET">
    <button class="btn btn-primary">📩 Envoyer les nouveaux produits par mail</button>
</form>

        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="fas fa-plus"></i> Nouveau Produit
            </button>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Rechercher un produit..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nombre de places</th>
                            <th>Matière</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    @if ($product->images)
                                        <img src="{{ asset('storage/' . $product->images[0]) }}"
                                            alt="{{ $product->nombre_places }}" class="img-thumbnail"
                                            style="max-width: 50px;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="No image" class="img-thumbnail"
                                            style="max-width: 50px;">
                                    @endif
                                </td>
                                <td>{{ $product->nombre_places }}</td>
                                <td>{{ $product->matiere }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                                        {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun produit trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal de création de produit -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Nouveau produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nombre_places" class="form-label">Nombre de places</label>
                                    <input type="text" class="form-control @error('nombre_places') is-invalid @enderror"
                                        id="nombre_places" name="nombre_places" value="{{ old('nombre_places') }}"
                                        required>
                                    @error('nombre_places')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="matiere" class="form-label">Matière utilisée</label>
                                    <input type="text" class="form-control @error('matiere') is-invalid @enderror"
                                        id="matiere" name="matiere" value="{{ old('matiere') }}" required>
                                    @error('matiere')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="5" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Prix (FCFA)</label>
                                            <input type="number"
                                                class="form-control @error('price') is-invalid @enderror" id="price"
                                                name="price" value="{{ old('price') }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Prix promotionnel (FCFA)</label>
                                            <input type="number"
                                                class="form-control @error('sale_price') is-invalid @enderror"
                                                id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                                            @error('sale_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number"
                                                class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                name="stock" value="{{ old('stock') }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Catégorie</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Images (2-8 photos)</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror"
                                        id="images" name="images[]" multiple accept="image/*" min="2"
                                        max="8" required>
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <ul class="mb-0">
                                            <li>Minimum 2 photos requises</li>
                                            <li>Maximum 8 photos autorisées</li>
                                            <li>Formats acceptés : JPG, PNG, GIF</li>
                                        </ul>
                                    </div>
                                    <div id="image-preview" class="mt-2 row g-2"></div>
                                    <div id="image-count" class="mt-2 text-muted small"></div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Produit actif</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured"
                                            name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Produit en vedette</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Prévisualisation des images
            document.getElementById('images').addEventListener('change', function(e) {
                const preview = document.getElementById('image-preview');
                const countDisplay = document.getElementById('image-count');
                preview.innerHTML = '';

                const files = e.target.files;
                const maxFiles = 8;
                const minFiles = 2;

                if (files.length < minFiles) {
                    alert(`Veuillez sélectionner au moins ${minFiles} photos.`);
                    this.value = '';
                    preview.innerHTML = '';
                    countDisplay.textContent = '';
                    return;
                }

                if (files.length > maxFiles) {
                    alert(`Vous ne pouvez pas sélectionner plus de ${maxFiles} photos.`);
                    this.value = '';
                    preview.innerHTML = '';
                    countDisplay.textContent = '';
                    return;
                }

                countDisplay.textContent = `${files.length} photo(s) sélectionnée(s)`;

                [...files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-4';

                        const wrapper = document.createElement('div');
                        wrapper.className = 'position-relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail w-100';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';

                        wrapper.appendChild(img);
                        col.appendChild(wrapper);
                        preview.appendChild(col);
                    }
                    reader.readAsDataURL(file);
                });
            });

            // Réinitialiser le formulaire quand le modal est fermé
            document.getElementById('createProductModal').addEventListener('hidden.bs.modal', function() {
                document.querySelector('form').reset();
                document.getElementById('image-preview').innerHTML = '';
                document.getElementById('image-count').textContent = '';
            });
        </script>
    @endpush
@endsection
