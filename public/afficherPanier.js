(function ($) {

    function nbrPanier() {
        var nbr = getPanierFromLocalStorage('panier').length;
        $(".total-cart").text(nbr);
    }


    function getPanierFromLocalStorage(param) {
        var resultats = JSON.parse(localStorage.getItem(param)) || [];
        return resultats;
    }


    var panier = [];


    //supression de la donnée du panier
    $('.supprimerProduit').click(function() {
        var produitId = $(this).data('data_id');
        supprimerDuPanier(produitId);
        afficherPanier();
    });

    function supprimerDuPanier(id) {
        var index = panier.findIndex(function(produit) {
            return produit.id === id;
        });

        if (index !== -1) {
            panier.splice(index, 1);
        }
    }

    function afficherPanier() {

        // Sélectionnez l'élément du tableau où vous voulez ajouter les données
        panier= getPanierFromLocalStorage('panier')
        var tableau = $('#panier-tableau');
        tableau.empty();

        // Boucle à travers le tableau PANIER et ajoutez les éléments au tableau HTML
        $.each(panier, function(index, item) {
            var images = item.image.split(';');
            var ligneHTML = '<tr>' +
                '<td class="product-thumbnail" >' +
                '<div class="column-box">' +
                '<figure class="prod-thumb">' +
                '<span class="cross-icon flaticon-cancel-1"><i class="fas  fa-trash" style="color: red" ></i></span>' +
                '<a href="#"><img src="http://127.0.0.1:8000/produit/'+images[0]+'" alt=""></a>'
                +
                '</figure>' +
                '</div>' +
                '</td>' +
                '<td class="product-name"  >' + item.nom + '</td>' +
                '<td class="price">' + item.prix + ' €</td>' +
                '<td class="quantity-box">' +
                '<div class="item-quantity">' +
                 '<input class="form-control quantite-input" type="number" value="' + item.quantite + '" name="quantity">' +
                '</div>' +
                '</td>' +
                '<td class="sub-total">' + (parseFloat(item.prix) * parseFloat(item.quantite)) + ' €</td>' +
                '</tr>';

            tableau.append(ligneHTML);
        });
        calculerMontantTotal(getPanierFromLocalStorage('panier'))
    }

    // Gestionnaire d'événements pour les champs de quantité
    $('#panier-tableau').on('input', '.quantite-input', function() {
        var row = $(this).closest('tr');
        var rowIndex = row.index();
        var nouvelleQuantite = parseInt($(this).val());

        // Vérifiez si la valeur est un nombre valide, sinon définissez la quantité sur 0
        if (isNaN(nouvelleQuantite) || nouvelleQuantite < 0) {
            nouvelleQuantite = 0;
        }

        panier[rowIndex].quantite = nouvelleQuantite;
        var sousTotal = parseFloat(panier[rowIndex].prix) * nouvelleQuantite;
        row.find('.sub-total').text(sousTotal.toFixed(2) + ' €');
        localStorage.setItem('panier', JSON.stringify(panier));
        calculerMontantTotal(getPanierFromLocalStorage('panier'))
    });

    function calculerMontantTotal(panier) {
        var montantTotal = 0;
        for (var i = 0; i < panier.length; i++) {
            var produit = panier[i];
            var sousTotal = parseFloat(produit.prix) * produit.quantite;
            montantTotal += sousTotal;
        }
        var resultats= montantTotal.toFixed(2);
        var totalePayer= parseFloat(resultats) + 3.58
        $('.total-montant').text(resultats+' €');
        $('.totale-a-payer').text(totalePayer.toFixed(2)+' €');

    }

    $('#panier-tableau').on('click', '.cross-icon', function() {
        panier= getPanierFromLocalStorage('panier')
        var rowIndex = $(this).closest('tr').index();
        panier.splice(rowIndex, 1);
        localStorage.setItem('panier', JSON.stringify(panier));
        $(this).closest('tr').remove();
        calculerMontantTotal(getPanierFromLocalStorage('panier'))

        afficherPanier()
        nbrPanier()
    });

    // Gestionnaire d'événements pour le bouton "Vider le panier"
    $('#vider-panier').on('click', function() {
        panier = [];
        localStorage.setItem('panier', JSON.stringify(panier));
        $('#panier-tableau tbody').empty();
        calculerMontantTotal(getPanierFromLocalStorage('panier'))
        afficherPanier()
        nbrPanier()
    });

    $('#acheter').on('click', function() {
       panier= getPanierFromLocalStorage('panier')
       $('#panier').val(JSON.stringify(panier)) ;
    });

    $('#proceder-au-paiement').on('click', function() {
        // Soumettez le formulaire avec l'ID "mon-formulaire"
        var paiement = $("input[name='paiement-type']:checked").val();
        panier= getPanierFromLocalStorage('panier')
        $('#panier').val(JSON.stringify(panier))
        $('#type-paiement-select').val(paiement) ;
        $('#mon-formulaire').submit();
    });


    afficherPanier()

})(jQuery);
