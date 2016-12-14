<?php echo $doctype."\n"; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang?>" lang="<?php echo $lang?>">
    <head>
        <title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <style type="text/css"><?php echo $style; ?></style>
    </head>
    <body>
        <div id="main"> <!-- Start of Main Div -->

            <div id="content"><!-- start of content -->
                <?php echo $page_content; ?>
            </div><!-- end of content -->
        </div> <!-- End Of main DIV -->
        <!-- javascript-->
        <?php
        foreach ($js_libs as $lib) echo "<script type=text/javascript src='".$js_path.$lib."'></script>\n\t";
        ?>
         
    </body>
</html>
