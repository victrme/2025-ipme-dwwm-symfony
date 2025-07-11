
## 1. 2025/07/11

- Faire un formulaire (il aura la route : "/admin/categorie/nouvelle"), qui permettra de créer de nouvelles catégories en base de données


## 2. 2025/07/11

- Faire un formulaire permettant d'ajouter un commentaire sur un jeu :
- Le formulaire sera intégré sur la page "/jeux/{slug}", il s'agira du jeu pour lequel le commentaire sera ajouté
- On renseignera seulement :
  - Le "rating" : un flottant allant de 0 à 5, et seulement de 0.5 en 0.5
  - Le "content" : le contenu du commentaire
- Le "createdAt" sera initialisé à la date du jour à la soumission du form
- Le "downVote" sera initialisé à 0
- Le "upVote" sera initialisé à 0
- Le "user" sera un utilisateur aléatoire de votre choix (à récupérer vous-même via le UserRepository)


## 3. 2025/07/11

- Faire un formulaire de création des "Publisher"
- (La difficulté réside sur le fait de relier l'entité à Country...)
