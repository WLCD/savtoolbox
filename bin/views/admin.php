<?php echo $doctype."\n";
    $acl = 0;
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang?>" lang="<?php echo $lang?>">
    <head>
        <title><?php echo $title; ?> - <?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <?php echo $style; ?>
    </head>
    <body>
        <div id="navbar">
            <div id="login"><?php echo $login; ?></div>
        </div>
        <div id="main"> <!-- Start of Main Div -->
            <div id="logo"><h1><?php echo $title; ?></h1></div>
            <div id="menu"><?php echo $menu; ?></div>
            <div id="content"><!-- start of content -->
            <?php 
                if($acl > $_SESSION['permissions'])
                {
                    echo "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
                }

                else 
                {
                    echo $page_content;
                }
            ?>
            </div><!-- end of content -->
        </div> <!-- End Of main DIV -->
        <!-- javascript-->
        <?php
        foreach ($js_libs as $lib) echo "<script type=text/javascript src='".$js_path.$lib."'></script>\n\t";
        ?>
         
    </body>
</html>
