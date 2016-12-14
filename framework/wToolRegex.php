<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wToolRegex
 *
 * @author wlcd
 */
class wToolRegex {
    
    public function match($pattern, $subject, $matches)
    {
        preg_match($pattern, $subject, $matches);
        return $matches;
    }

    public function replace($pattern, $replacement, $subject)
    {
        $replace = preg_replace($pattern, $replacement, $subject);
        return $replace;
    }
}
?>
