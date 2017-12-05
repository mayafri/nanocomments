# NanoComments

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

