$(document).ready(function () {
    let promoApplied = false;

    const promoSection = $('#promo-section');
    const validateButton = $('#validate-button');
    const cartBody = $('#cart-body');
    const cartBadge = $('.cart-badge');
    const totalAmountElement = $("#total-amount");
    const discountedTotalElement = $("#discounted-total");
    const emptyRowHTML = `
        <tr id="empty-row">
            <td colspan="5" style="font-size: 12px" class="text-center text-muted">
                Aucun produit ajouté pour l’instant.
            </td>
        </tr>`;

    function getProductCount() {
        return cartBody.find('tr:not(#empty-row)').length;
    }

    // Vérifie si un produit avec cet ID est déjà dans le panier
    function isProductAlreadyAdded(productId) {
        let isAdded = false;
        cartBody.find('tr:not(#empty-row)').each(function () {
            const existingProductId = $(this).find('input[name^="produits"][name$="[id]"]').val();
            if (existingProductId === productId) {
                isAdded = true;
                return false; // Sortir de la boucle .each
            }
        });
        return isAdded;
    }

    function calculateTotalAmount() {
        let currentTotal = 0;
        cartBody.find('input[name^="produits"][name$="[montant]"]').each(function () {
            currentTotal += parseFloat($(this).val()) || 0;
        });

         // Met à jour la valeur de l'input (chaine formatée)
        $('#total-amount-input').val(`${formatPrice(currentTotal)} FCFA`);
        return currentTotal;
    }

    function updateTotalsDisplay() {
        const currentTotalAmount = calculateTotalAmount();
        totalAmountElement.text(`${formatPrice(currentTotalAmount)} FCFA`);

        if (promoApplied) {
            const reduced = currentTotalAmount * 0.95; // 5% de réduction
             $('#total-promo-code').val(`${formatPrice(reduced)} FCFA`);

            discountedTotalElement.text(`${formatPrice(reduced)} FCFA`);
        } else {
            discountedTotalElement.text(`${formatPrice(currentTotalAmount)} FCFA`);
            $('#total-promo-code').val(`${formatPrice(currentTotalAmount)} FCFA`);
        }
    }

    function formatPrice(value) {
        return value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    // Met à jour l'état de tous les boutons "Ajouter au panier" sur la page
    function updateAddToCartButtonStates() {
        $('.add-to-cart').each(function () {
            const $button = $(this);
            const productId = $button.data('id');
            if (productId && isProductAlreadyAdded(String(productId))) { // Convertir productId en string pour la comparaison
                $button.prop('disabled', true).text('Déjà ajouté');
            } else {
                // Assurez-vous que le texte original est restauré si besoin, ou utilisez un texte par défaut
                // Si vous avez un texte original stocké, utilisez-le. Sinon :
                $button.prop('disabled', false).text('+ Ajouter au panier'); // Ou le texte original de votre bouton
            }
        });
    }

    function updateCartDisplay() {
        const productCount = getProductCount();
        cartBadge.text(productCount);
        updateTotalsDisplay();
        saveCartToLocalStorage();
        updateAddToCartButtonStates(); // Mettre à jour l'état des boutons

        if (productCount > 0) {
            promoSection.show();
            validateButton.show();
            $('#empty-row').remove();
        } else {
            promoSection.hide();
            validateButton.hide();
            if (cartBody.find('#empty-row').length === 0) {
                cartBody.append(emptyRowHTML);
            }
        }
    }

    // Ajout du produit au panier
    function addProductToCart(id, name, price, img, quantite = 1) {

        // Validation des données d'entrée
        if (!id || !name || typeof price !== 'number' || isNaN(price) || price <= 0 || !img) {
            console.error("Données produit invalides pour l'ajout :", { id, name, price, img });
            alert("Impossible d'ajouter le produit : informations manquantes ou incorrectes.");
            return;
        }


        if (isProductAlreadyAdded(String(id))) { // Convertir id en string pour la comparaison
            // Déjà géré par updateAddToCartButtonStates, mais une alerte peut être utile
            // alert('Ce produit est déjà dans votre panier.');
            return;
        }
        const index = getProductCount(); // <<< 🔹 AJOUT ICI 🔹
        const montant = quantite * price;

        // L'image est bien utilisée ici via la variable `img`
        const newRow = `
            <tr>
                <td class="d-flex flex-column align-items-center">
                    <img style="width: 50px;" src="${img}" alt="${name}">

                    <strong class="text-center" style="font-size: 12px">${name}</strong>
                    <input type="hidden" name="produits[${index}][id]" value="${id}">
                    <input type="hidden" name="produits[${index}][nom]" value="${name}">
                    <input type="hidden" name="produits[${index}][image]" value="${img}">
                </td>
                <td>
                    <input type="number" name="produits[${index}][quantite]" value="${quantite}" class="form-control form-control-sm w-75 mx-auto" min="1" data-product-id="${id}">
                </td>
                <td>
                    <input type="text" name="produits[${index}][prix]" value="${price}" class="form-control form-control-sm w-100" readonly>
                </td>
                <td>
                    <input type="text" name="produits[${index}][montant]" value="${montant}" class="form-control form-control-sm w-100" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="fa-solid fa-trash text-white"></i>
                    </button>
                </td>
            </tr>
        `;

        cartBody.append(newRow);
        updateCartDisplay(); // Met à jour tout, y compris l'état des boutons
    }

    function saveCartToLocalStorage() {
        const cartData = [];
        cartBody.find('tr:not(#empty-row)').each(function () {
            const id = $(this).find('input[name^="produits"][name$="[id]"]').val();
            const name = $(this).find('input[name^="produits"][name$="[nom]"]').val();
            const img = $(this).find('input[name^="produits"][name$="[image]"]').val();
            const prix = parseFloat($(this).find('input[name^="produits"][name$="[prix]"]').val());
            const quantite = parseInt($(this).find('input[name^="produits"][name$="[quantite]"]').val());

            if (id && name && img && !isNaN(prix) && !isNaN(quantite)) {
                 cartData.push({ id, name, img, prix, quantite });
            }
        });

        if (cartData.length > 0) {
            localStorage.setItem('cartData', JSON.stringify(cartData));
        } else {
            localStorage.removeItem('cartData');
        }
    }

    function loadCartFromLocalStorage() {
        const data = JSON.parse(localStorage.getItem('cartData') || '[]');
        if (data.length === 0) {
            return;
        }

        data.forEach(product => {
            if (product.id && product.name && typeof product.prix === 'number' && !isNaN(product.prix) && product.img && typeof product.quantite === 'number' && !isNaN(product.quantite)) {
                // Note: addProductToCart va appeler updateCartDisplay, qui appellera updateAddToCartButtonStates
                addProductToCart(product.id, product.name, product.prix, product.img, product.quantite);
            } else {
                console.warn("Produit invalide trouvé dans localStorage:", product);
            }
        });
        // updateCartDisplay sera appelé à la fin de l'initialisation globale
    }

    // --- ÉCOUTEURS D'ÉVÉNEMENTS ---

    $('.add-to-cart').click(function () {
        const $button = $(this);
        const productId = $button.data('id'); // Récupérer l'ID
        const name = $button.data('name');
        const priceString = $button.data('price');
        const img = $button.data('img'); // L'image principale est récupérée ici

        // Validation des données du bouton
        if (!productId) {
            console.error("ID du produit manquant sur le bouton.");
            alert("Erreur : ID du produit manquant.");
            return;
        }
        if (!name || typeof name !== 'string' || name.trim() === "") {
            console.error("Nom du produit manquant ou invalide.");
            alert("Erreur : Nom du produit manquant ou invalide.");
            return;
        }
        if (!priceString) {
            console.error("Prix du produit manquant.");
            alert("Erreur : Prix du produit manquant.");
            return;
        }
        const price = parseFloat(priceString);
        if (isNaN(price) || price <= 0) {
            console.error("Prix du produit invalide:", priceString);
            alert("Erreur : Prix du produit invalide.");
            return;
        }
        if (!img || typeof img !== 'string' || img.trim() === "") {
            console.error("Image du produit manquante ou invalide.");
            alert("Erreur : Image du produit manquante ou invalide.");
            return;
        }

        if (isProductAlreadyAdded(String(productId))) { // Convertir productId en string pour la comparaison
            alert('Ce produit est déjà dans votre panier.');
            return;
        }

        addProductToCart(String(productId), name, price, img); // Convertir productId en string
    });

    cartBody.on('click', '.remove-item', function () {
        const row = $(this).closest('tr');
        const productId = row.find('input[name^="produits"][name$="[id]"]').val();

        row.remove();

        promoApplied = false;
        $('#promo-code').val('');
        $('#promo-message').hide().removeClass('text-success text-danger').text('');
        $('#promo-error').remove();

        updateCartDisplay(); // Cela va aussi appeler updateAddToCartButtonStates pour réactiver le bouton
    });

    cartBody.on('input change', 'input[name^="produits"][name$="[quantite]"]', function () {
        const row = $(this).closest('tr');
        let quantite = parseInt($(this).val());

        if (isNaN(quantite) || quantite < 1) {
            quantite = 1;
            $(this).val(1);
        }

        const prix = parseFloat(row.find('input[name^="produits"][name$="[prix]"]').val());
        const montant = quantite * prix;

        row.find('input[name^="produits"][name$="[montant]"]').val(montant.toFixed(0));
        updateCartDisplay(); // Met à jour les totaux et sauvegarde
    });

    $('#promo-section').on('click', 'button', function() {
        const code = $("#promo-code").val().trim();
        const promoMsgElement = $("#promo-message");

        $('#promo-error').remove();
        promoMsgElement.hide().removeClass('text-success text-danger').text('');

        if (code === "PROMO5") {
            promoApplied = true;
            promoMsgElement.text("✅ Code appliqué : réduction de 5%").addClass('text-success').show();
        } else if (code === "") {
            promoApplied = false;
            promoMsgElement.text("").hide();
        } else {
            promoApplied = false;
            const error = `<div class="alert alert-danger mt-2 small" id="promo-error">❌ Code promo invalide !</div>`;
            $('#promo-code').parent().after(error);
        }
        updateTotalsDisplay(); // Seulement mettre à jour l'affichage des totaux
    });

    $("#promo-code").on('input', function() {
        $('#promo-error').remove();
        if ($(this).val().trim() === "") {
             promoApplied = false;
             $("#promo-message").hide().removeClass('text-success text-danger').text('');
             updateTotalsDisplay();
        }
    });

    $('.add-to-cart-btn').on('click', function () { // Semble être pour les boutons de partage, pas d'ajout au panier
        const $container = $(this).closest('.col');
        const $shareDiv = $container.find('.share-options');
        $shareDiv.toggleClass('d-none');
    });

    // --- INITIALISATION ---
    loadCartFromLocalStorage(); // Charge les produits et met à jour implicitement les boutons via addProductToCart
    updateCartDisplay();      // Appel final pour s'assurer que tout est correct (surtout si le panier était vide)
});

$(document).ready(function () {
        // Lorsqu'on clique sur le bouton "Soumettre"
        $('#confirmModal #button-send').on('click', function () {
            let isValid = true;

            // Récupération des champs
            let name = $('#name').val().trim();
            let email = $('#email').val().trim();
            let phone = $('#phone').val().trim();
            let indicatif = $('#indicatif').val().trim();

            // Réinitialiser les styles
            $('#name, #email, #phone').removeClass('is-invalid');

            // Vérification du nom
            if (name === '') {
                $('#name').addClass('is-invalid');
                isValid = false;
            }

            // Vérification de l’email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '' || !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            }

            // Vérification du téléphone
            if (phone === '' || isNaN(phone)) {
                $('#phone').addClass('is-invalid');
                isValid = false;
            }

            // Vérification du téléphone
            if (indicatif === '' ) {
                $('#indicatif').addClass('is-invalid');
                isValid = false;
            }

            // Si tout est valide, soumettre le formulaire
            if (isValid) {
                $('#product-form').submit();
            }
        });

        // Supprimer le style d'erreur en cas de saisie
        $('#name, #email, #phone, #indicatif').on('input', function () {
            $(this).removeClass('is-invalid');
        });
    });
