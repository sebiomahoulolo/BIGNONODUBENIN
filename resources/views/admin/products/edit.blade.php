@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier le Produit</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Informations principales -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nombre_places" class="form-label">Nombre de places</label>
                        <input type="text" class="form-control @error('nombre_places') is-invalid @enderror" 
                            id="nombre_places" name="nombre_places" 
                            value="{{ old('nombre_places', $product->nombre_places) }}" required>
                        @error('nombre_places')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="matiere" class="form-label">Matière utilisée</label>
                        <input type="text" class="form-control @error('matiere') is-invalid @enderror" 
                            id="matiere" name="matiere" 
                            value="{{ old('matiere', $product->matiere) }}" required>
                        @error('matiere')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Prix (FCFA)</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options et images -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Images actuelles</label>
                        <div class="row g-2" id="current-images">
                            @foreach($product->images as $image)
                                <div class="col-4 mb-2">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Image produit" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                                onclick="deleteImage('{{ $image }}')" 
                                                {{ count($product->images) <= 2 ? 'disabled' : '' }}
                                                title="{{ count($product->images) <= 2 ? 'Minimum 2 photos requises' : 'Supprimer cette image' }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-muted small mt-2">
                            {{ count($product->images) }} photo(s) actuelle(s) - Minimum 2 photos requises
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Ajouter des nouvelles images</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                            id="images" name="images[]" multiple accept="image/*">
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <ul class="mb-0">
                                <li>Maximum 8 photos au total</li>
                                <li>Formats acceptés : JPG, PNG, GIF</li>
                                <li>Vous pouvez ajouter jusqu'à {{ 8 - count($product->images) }} photo(s) supplémentaire(s)</li>
                            </ul>
                        </div>
                        <div id="image-preview" class="mt-2 row g-2"></div>
                        <div id="image-count" class="mt-2 text-muted small"></div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Produit actif</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Produit en vedette</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Prévisualisation des nouvelles images
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const countDisplay = document.getElementById('image-count');
        preview.innerHTML = '';
        
        const files = e.target.files;
        const currentImages = {{ count($product->images) }};
        const maxFiles = 8;
        const remainingSlots = maxFiles - currentImages;

        if (files.length > remainingSlots) {
            alert(`Vous ne pouvez ajouter que ${remainingSlots} photo(s) supplémentaire(s) pour respecter la limite de ${maxFiles} photos.`);
            this.value = '';
            preview.innerHTML = '';
            countDisplay.textContent = '';
            return;
        }

        countDisplay.textContent = `${files.length} nouvelle(s) photo(s) sélectionnée(s)`;
        
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

    // Suppression d'une image
    function deleteImage(imagePath) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            fetch(`{{ route('admin.products.delete-image', $product) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image: imagePath })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément de l'interface
                    const imageElement = document.querySelector(`img[src="{{ asset('storage/') }}/${imagePath}"]`).parentElement.parentElement;
                    imageElement.remove();
                    
                    // Mettre à jour le compteur d'images
                    const currentImages = document.querySelectorAll('#current-images .col-4').length;
                    document.querySelector('.text-muted.small.mt-2').textContent = 
                        `${currentImages} photo(s) actuelle(s) - Minimum 2 photos requises`;
                    
                    // Mettre à jour les boutons de suppression
                    const deleteButtons = document.querySelectorAll('#current-images .btn-danger');
                    deleteButtons.forEach(button => {
                        if (currentImages <= 2) {
                            button.disabled = true;
                            button.title = 'Minimum 2 photos requises';
                        }
                    });
                    
                    // Mettre à jour le message des nouvelles images
                    const remainingSlots = 8 - currentImages;
                    const formText = document.querySelector('.form-text ul li:last-child');
                    formText.textContent = `Vous pouvez ajouter jusqu'à ${remainingSlots} photo(s) supplémentaire(s)`;
                }
            });
        }
    }
</script>
@endpush
@endsection 