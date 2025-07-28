
# AJAX (Asynchronous JavaScript and XML)

### 1. Principe

Effectuer des requêtes HTTP de manière asynchrone, c'est-à-dire en parallèle de notre processus courant.

### 2. Comment qu'on fait ???

Dans un 1er temps on va souvent chercher un élément de notre DOM, sur lequel ajouter un évènement (click, hover, etc) qui déclenchera la requête HTTP.

Exemple (avec un click) :

Imaginons cet HTML :

```html

<button class="btn btn-primary" data-wish-list>
    Click me !
</button>

```

```js

function initButtonWishList() {
    const buttons = document.querySelectorAll('[data-wish-list]');
    buttons.forEach((button) => {
       button.addEventListener('click', () => {
           // Code pour lancer le fetch, voir ci-dessous
       }) ;
    });
}

window.addEventListener('load', () => {
   initButtonWishList(); 
});

```

Créer une requête HTTP

```js

// Lors des requêtes HTTP sur notre serveur PHP
// pas besoin de repréciser "http://localhost:8000"
// le domaine du serveur à appeler
// il le fait implicitement
// (PS : penser à bien créer une ROUTE dans votre Symfony, avec le chemin "/my-route")
fetch("/my-route")
    .then((response) => {
        if (response.status === 200) {
            return response.json();
        }
        // Traiter les cas d'erreur
    })
    .then((jsonContent) => {
       // Votre traitement avec le contenu JSON de la réponse
        // Comme modifier le DOM ? Ajouter du contenu HTML ? En supprimer ? 
    });

```





