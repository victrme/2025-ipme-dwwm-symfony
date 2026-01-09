
function initButtonWishList(): void {
    const buttons: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-wishlist]');
    buttons.forEach((button) => {
        const url: string = button.dataset.wishlist;
        button.addEventListener('click', () => {
            fetch(url, {method: 'POST'})
                .then((response) => {
                    if (response.status === 200) {
                        return response.json();
                    }
                    // Traiter les cas d'erreur
                })
                .then((jsonContent) => {
                    if (jsonContent === 200) {
                        button.innerHTML = '<i class="fa-solid fa-heart text-danger"></i>';
                        button.title = 'Retirer ce jeu de votre liste de souhait !';
                    } else if (jsonContent === 100) {
                        button.innerHTML = '<i class="fa-regular fa-heart"></i>';
                        button.title = 'Ajouter ce jeu à votre liste de souhait !';
                    } else {
                        window.location.href = jsonContent;
                    }
                });
        });
        button.removeAttribute('data-wishlist'); // Sécurité pour ne pas communiquer d'informations sur nos routes AJAX
    });
}

window.addEventListener('load', () => {
    initButtonWishList();
});
