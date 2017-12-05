#NanoComments

A tiny comments system in PHP + flat file.

## How to use ?

Copy `nanocomments.php` anywhere and set permissions to forbidden anybody to call the file directly from the browser.

```
chmod 700 nanocomments.php
```

Include `nanocomments.php` in your CMS like this, and define specific variables. If you don't know how to pass the page ID or name to the script, read your CMS documentation.

```
<?php 

$nanocomments_dir = "commentsdata/";
$nanocomments_pageid = $CMS_PAGE_NAME_OR_ID;
$nanocomments_sizelimit = 500; // Optional
include("../nanocomments/nanocomments.php");

?>
```

