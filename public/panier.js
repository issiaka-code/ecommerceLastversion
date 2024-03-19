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

    function ajouterAuPanier(id, nom, prix, image) {
        // Récupérer le panier à partir du cookie ou initialiser un nouveau tableau vide

        panier= getPanierFromLocalStorage('panier')
        var produitExistant = panier.find(function(produit) {
            return produit.id === id;
        });

        if (produitExistant) {
            produitExistant.quantite++;
        } else {
            var nouveauProduit = {
                id: id,
                nom: nom,
                prix: prix,
                image: image,
                quantite: 1
            };
            panier.push(nouveauProduit);
        }

        // Stocker le panier mis à jour dans le cookie
        localStorage.setItem('panier', JSON.stringify(panier));
        nbrPanier()
    }


// Écouter le clic sur le bouton "Ajouter Produit" en utilisant jQuery

        $('.cart').click(function() {
            // Simuler l'ajout d'un produit avec un identifiant (ici, 1)
            var produitId =  $(this).attr('data_id');
            $('.overlay').removeClass('hidden');

            $.ajax({
                url: `/info/produit/${produitId}`, // URL de l'API Symfony
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    ajouterAuPanier(produitId,response.nom,response.prix,response.image);
                    $('.overlay').addClass('hidden');
                },
                error: function(error) {
                    // Gestion des erreurs
                    console.error('Erreur lors de la requête AJAX : ' + error.statusText);
                }
            });
        });

    nbrPanier()

})(jQuery);
