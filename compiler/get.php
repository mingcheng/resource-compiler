<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8 nobomb:
/**
 * Download the minized file then delete it.
 *
 * @author mingcheng<i.feelinglucky#gmail.com>
 * @date   2010-12-29
 */

require_once "../config.inc.php";

if ($_GET['file']) {
    $file_name = $_GET['file'];

    $get_file = realpath(DIR_TMP . '/' . $file_name);
    if (!$get_file) {
        header("Location:".URL_ROOT, true, 301);
        exit;
    }

    header("Content-Type: application/force-download"); 
    header("Content-Disposition: attachment;filename=$file_name");    
    echo file_get_contents($get_file);
    @unlink($get_file);
}
