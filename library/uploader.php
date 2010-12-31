<?php
/**
 * Handle file uploads via XMLHttpRequest
 */

define('QQ_UPLOAD_FILE_FIELD', 'upload_file');

class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp  = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET[QQ_UPLOAD_FILE_FIELD];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES[QQ_UPLOAD_FILE_FIELD]['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES[QQ_UPLOAD_FILE_FIELD]['name'];
    }
    function getSize() {
        return $_FILES[QQ_UPLOAD_FILE_FIELD]['size'];
    }
}


class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit         = 10485760;
    private $file  = null;
    private $error = null;

    function __construct(array $allowedExtensions = array(), $sizeLimit = MAX_UPLOAD_FILE_SIZE) {        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET[QQ_UPLOAD_FILE_FIELD])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES[QQ_UPLOAD_FILE_FIELD])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize   = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }
    }
    
    private function toBytes($str){
        $val  = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE) {
        if (!is_writable($uploadDirectory)){
            $this->error = "Server error. Upload directory isn't writable.";
            return false;
        }
        
        if (!$this->file){
            $this->error = 'No files were uploaded.';
            return false;
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            $this->error = 'File is empty';;
            return false;
        }
        
        if ($size > $this->sizeLimit) {
            $this->error = 'File is too large';
            return false;
        }
        
        $pathinfo = pathinfo($this->file->getName());
        //$filename = $pathinfo['filename'];
        $filename = md5(uniqid());
        $ext      = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            $this->error = 'File has an invalid extension, it should be one of '. $these . '.';
            return false;
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        $filename = $uploadDirectory . '/' . $filename . '.' . $ext;
        return $this->file->save($filename) ? realpath($filename) : false;
    }

    public function getName() {
        return $this->file ? $this->file->getName() : null;
    }

    public function getError() {
        return $this->error;
    }
}
