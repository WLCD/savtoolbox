<?php
$page_content = "<p>La page que vous cherchez n'existe pas.</p>
<p><a href='?rt=index'>Page d'acceuil</a></p>
<p><a href='".$_SERVER['HTTP_REFERER']."'>Page Précédente</a></p>";

include __SITE_PATH . '/bin/views/' . 'index.php';

?>

