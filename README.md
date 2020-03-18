# NanoComments

*See below for English.*

NanoComments est un système de commentaires en Javascript et PHP sans base de données optimisé pour les sites statiques faits avec Jekyll.

## Fonctionnalités

 - Permet de poster des commentaires sur des articles avec comme informations : pseudo, site, contenu du message.
 - Commentaires stockés dans des fichiers JSON humainement lisibles et éditables.
 - Formatage Markdown basique supporté (gras, italique, liens et texte monospace).
 - Fichier de log pour surveiller les nouveaux commentaires.

## Installation

 1. Copiez le dossier `comments/` dans la racine du site.
 2. Assurez-vous que le serveur pourra créer et éditer des fichiers dans ce dossier.
 3. Ajoutez la zone de commentaires en vous inspirant du fichier `index.html`.

## Configuration / hack

 1. Par défaut, chaque fichier de commentaire est limité à 500 ko. Pour modifier cette limite, allez dans `addComment.php` dans la fonction `is_filesize_correct` et changez la valeur multipliée par 1024 (par défaut `500 * 1024` pour 500 ko).
 
 2. Par défaut, le fichier de log est limité aux 100 dernières entrées. Pour faire varier cette valeur, dans `addComment.php` allez dans `add_comment_to_logfile` et changez le nombre  dans la condition appropriée.
 
 3. Pour désactiver le log, commentez ou retirez les deux lignes qui commencent par `add_comment_to_logfile`... à la fin du mêne  fichier.
 
 4. Pour changer le nombre de caractères max du pseudo, du site ou du contenu, changez les valeurs aux endroits où les variables `$name`, `$website` et `$content` sont créées, aux alentours de la ligne 80. Vous devrez aussi mettre à jour les valeurs dans le formulaire HTML (champs `maxlength`).

---

NanoComments is a flat-file comment system (written in Javascript and PHP) designed for static websites and optimized for Jekyll.

## Features

 - Allow users to post comments with data : name, website, message content.
 - Comments are stored in files, in a human-readable and editable JSON format.
 - Basic Markdown formatting (bold, italic, links and monospace text).
 - Logfile to track new comments.

## Setup

 1. Copy `comments/` directory in the website root folder.
 2. Check rights for this directory. The server may be allowed to create and edit files here.
 3. Add a comment section in your website (see example in `index.html`).

# Customization / hack

 1. By default, any comments file is limited to 500 ko. If you want to modify this limit, go to `addComment.php` in function `is_filesize_correct` and change the value multiplied by 1024 (by default it's `500 * 1024` for 500 ko).
 
 2. By default, the logfile is limited to 100 lines. If you want to modify this value, in `addComment.php` go to `add_comment_to_logfile` and change the number in the appropriate `if`.
 
 3. If you want to disable the logfile, comment or remove the two calls `add_comment_to_logfile`... at the end of `addComment.php`.
 
 4. If you want to modify the maximum length of strings like name, website or comment content, change numbers where `$name`, `$website` and `$content` vars are created (around line 80) and change corresponding values in the HTML form (`maxlength` fields).
