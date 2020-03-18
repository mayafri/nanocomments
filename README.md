# [FR] NanoComments

NanoComments est un système de commentaires en Javascript et PHP sans base de données optimisé pour les sites statiques faits avec Jekyll. Les commentaires sont stockés dans des fichiers JSON.

## Fonctionnalités

 - Permet de poster des commentaires sur des articles avec comme informations : pseudo, site, contenu du message.
 - Commentiares stockés dans des fichiers JSON humainement lisibles et éditables.
 - Formatage Markdown basique supporté (gras, italique, liens et texte monospace).
 - Fichier de log pour surveiller les nouveaux commentaires.

## Installation

 1. Copiez le dossier comments/ dans la racine du site.
 2. Assurez-vous que le serveur pourra créer et éditer des fichiers dans ce dossier.
 3. Ajoutez la zone de commentaires en vous inspirant du fichier `index.html`.

## Configuration / hack

 1. Par défaut, chaque fichier de commentaire est limité à 500 ko. Pour modifier cette limite, allez dans `addComment.php` dans la fonction `is_filesize_correct` et changez la valeur multipliée par 1024 (par défaut `500 * 1024` pour 500 ko).
 
 2. Par défaut, le fichier de log est limité aux 100 dernières entrées, pour faire varier cette valeur, dans `addComment.php` allez dans `add_comment_to_logfile` et changez le nombre  dans la condition appropriée.
 
 3. Pour désactiver le log, retirez les deux lignes qui commencent par `add_comment_to_logfile`... à la fin du fichier.
 
 4. Pour changer le nombre de caractères max du pseudo, du site ou du contenu, changez les valeurs aux endroits où les variables `$name`, `$website` et `$content` sont créees, aux alentours de la ligne 80. Vous devrez aussi mettre à jour les valeurs dans le formulaire HTML (champs `maxlength`).
