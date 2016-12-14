<?php
/**
 * Description of wToolFiles
 * This Class is intended to handle files manipulations
 * @author wlcd
 */
class wToolFiles {

    // return file content in binary mode
    public function open($filename, $mode)
    {
        $file = fopen($filename, $mode);
        return $file;
    }

    // return array containing one line per index
    public function file($filename)
    {
        $lines = file($filename);
        return $lines;
    }

    // return file content as string
    public function getContents($filename)
    {
        $contents = file_get_contents($filename);
        return $contents;
    }
}
?>
