<?php echo $doctype."\n";
$acl = 2;
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang?>" lang="<?php echo $lang?>">
    <head>
        <title><?php echo $title; ?> - <?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <?php echo $style; ?>
        <!-- javascript         -->
        <?php
        foreach ($js_libs as $lib) echo "<script type=text/javascript src='".$js_path.$lib."'></script>\n\t";
        ?>
    </head>
    <body>
        <div id="navbar">
            <div id="login"><?php echo $login; ?></div>
        </div>
        <div id="main"> <!-- Start of Main Div -->
            <div id="logo"><h1><?php echo $title; ?></h1></div>
            <div id="menu"><?php echo $menu; ?></div>
            <div id="content"><!-- start of content -->
                <div id="news">
                    <?php echo $page_content; ?>
                </div>                
            </div><!-- end of content -->
        </div> <!-- End Of main DIV -->
        
    </body>
</html>
