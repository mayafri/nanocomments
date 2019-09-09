# [FR] NanoComments

Un petit système de commentaires en PHP sans base de données (stockage dans un fichier).

## Comment l'utiliser ?

Cloner ou copier `nanocomments.php` n'importe où.

Inclure `nanocomments.php` dans votre CMS et définir les variables spéficiques (exemple ci-dessous). Pour savoir comment passer l'ID de la page ou son nom au script, cherchez dans la documentation ou le code de votre CMS.

---

# [EN] NanoComments

A tiny comments system in PHP + flat file.

## How to use ?

Clone or copy `nanocomments.php` anywhere.

Include `nanocomments.php` in your CMS like this, and define specific variables. If you don't know how to pass the page ID or name to the script, read your CMS documentation.

```
<?php 

$nanocomments_dir = "commentsdata/";
$nanocomments_pageid = $CMS_PAGE_NAME_OR_ID;
$nanocomments_sizelimit = 500; // Optional
$nanocomments_dateformat = "Y-m-d H:i:s"; // Optional, check PHP date doc
include("../nanocomments/nanocomments.php");

?>
```

