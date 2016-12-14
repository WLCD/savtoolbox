<?php
/**
 * Description of style
 *
 * @author wlcd
 */
class style {
    
    private $registry;
    
    function __construct($registry) {
        $this->registry = $registry;
    }
    
    public function genStyleSheets()
    {
        $style = 'bin/'.$this->registry->settings->style_path.'/'.$this->registry->settings->style_name.'/'.$this->registry->settings->style_name.'.info';

        //ouverture du fichier, stockage des lignes dans un tableau, puis fermeture
        $desc_file = file($style);

        foreach ($desc_file as $line)
        {
            //tester si les lignes commence par le caractère ";" ou par " "
            //pour skipper les commentaires et les lignes vides du fichier
            if(preg_match('`^[^;]{1}`',$line) && preg_match('`^[^ ]{2,}`',$line))
            {
                //on éclate la ligne en fonction du séparateur "="
                $param = explode('=',substr($line, 0, -1));

                //traiter $param pour enlever les espaces après les chaines
                $param_name = preg_replace('`[ ]{1,}$`', '', $param[0]);

                //traiter $param pour enlever les espaces avant les chaines
                $param_setting = preg_replace('`^[ ]{1,}`', '', $param[1]);

                //si la chaine finit par " []]...
                if(preg_match('`[][]{2}$`', $param_name))
                {
                    //...alors c'est un tableau
                    $array_param[] = $param_setting;

                    //construction du tableau de paramètres du thème
                    $info[$param_name] = $array_param;
                }

                else
                {
                    //construction du tableau de paramètres du thème
                    $info[$param_name] = $param_setting;
                }
            }
        }

        //assigner les valeur du tableau à des variables pour faciliter leur
        //manipulation, sur le long termes, les passer à l'objet "Session"
        //        $theme_name = $info['name'];
        //        $theme_desc = $info['description'];
        //        $theme_screenshot = $info['screenshot'];
        $theme_stylesheets = $info['stylesheets[]'];
        
        //chargement de chaque fichier CSS du theme
        
        foreach ($theme_stylesheets as $sheet)
        {
            $stylesheet[] = '<link href="bin/'.$this->registry->settings->style_path.'/'.$this->registry->settings->style_name.'/'.$sheet.'" rel="stylesheet" type="text/css" />';   
            //$this->registry->console->message($sheet.' chargé !<br />');
        }
        return implode($stylesheet);
    }
}

?>
