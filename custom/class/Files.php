<?php

/**
 * \brief File uploading made-easy
 * 
 * @author Shafiul Azam
 * 
 * WARNING: CODES IN THIS FILE MIGHT BE BUGGY, NOT TESTED YET BY THE PROGRAMMER.
 */

class Files{
    
    public $name;
    public $targetDir;  ///< directory to which the file would be copied, MUST END WITH FORWARD SLASH (/)
    public $targetFileName = null;
    public $sizeLimit = null;
    public $AllowedMimeArr = null;
    public $AllowedextentionArr = null; ///< Must give in all lowercase
    public $ifFileExists;
    public $targetFilePermission;


    public function __construct() {
        // Set some default configuration
        $this->ifFileExists = "overwrite";
        $this->targetFilePermission = 0664; // For files
//        $this->targetFilePermission = 0774; // For directories
    }

        /**
     * File upload helper via web forms. Call this function after you've uploaded a file via web form
     * @param string $name "name" attribute of the <input> tag used for the file
     * @param string $targetDir directory to which the file would be copied
     * @param string $targetFileName if non-empty, file would be renamed to this name
     * @param int $sizeLimit if non-empty, this number specifies the maximum number of bytes the file can be in size
     * @param array $mimeTypeArr array of mime type strings, if non-empty the file must be one of these mime type.
     * @return array
     *  -   0th Element: bool | true if file upload successful
     *  -   1st Element: string | status string to be presented to user 
     *      -   Special case:
     *      -   If no file was selected by the user, 0th element is true, 1st element is string "NIL"  
     */
    
    public function upload() {
        // file upload processing! $name is the NAME attribute of the <input> tag.
        // If $targetFileName is provided, that name will be used when saving the uploaded file
        // otherwise original name will be used while saving the uploaded file.
        // RETURNS FALSE FOR SUCCESSFUL UPLOAD, OTHERWISE AN ERROR MESSAGE.
        //error checking
        if ($_FILES[$this->name]["size"] <= 0)
            return array(true,"NIL","");   // No file selected -- no upload!
        if ($_FILES[$this->name]["error"] > 0)
            return array(false,$_FILES["file"]["error"]);
        // size check
        if ($this->sizeLimit && ($_FILES[$this->name]["size"] > $this->sizeLimit))
            return array(false,"File to large, max limit is " . $this->sizeLimit . " bytes");
        // MIMETYPE CHECK
        if (!empty($this->mimeTypeArr)) {
            if (!in_array(strtolower($_FILES[$this->name]["type"]), $this->mimeTypeArr))
                return array(false,"This type of file (" . $_FILES[$this->name]['type'] . ") is not allowed for upload.");
        }
        // Check extention 
        $pathinfo = pathinfo($_FILES[$this->name]['name']);
        $fileExtention = strtolower($pathinfo['extension']);
        
        if(!in_array($fileExtention, $this->AllowedextentionArr))
            return array(false,"This file extention is not allowed.");
        
        // ALLOWED FOR UPLOAD. GENERATE TARGET FILE PATH
        if (!$this->targetFileName)
            $this->targetFileName = basename($_FILES[$this->name]['name']);
        $targetPath = $this->targetDir . $this->targetFileName . ".$fileExtention";
        // What if file already exists?
        if(file_exists($targetPath)){
            switch ($this->ifFileExists){
                case 'overwrite':
                    break;
                case 'fail':
                    return array(false,"File already exists. Try again renaming the file.");
                    break;
                case 'rename':
                    $pathinfo = pathinfo($targetPath);
                    $targetPath = $pathinfo['dirname'] . "/" . $pathinfo['filename'] . "_" . date("jMY-g-i-a", time()) . "." . $pathinfo['extension'];
                    break;
            }
            
//            echo $targetPath;
//            exit();
        }
        // UPLOAD
        if (move_uploaded_file($_FILES[$this->name]['tmp_name'], $targetPath)) {
            // CHMOD
            chmod($targetPath, $this->targetFilePermission);
        } else {
            //echo $_FILES[$this->name]['tmp_name'] . ":" . $targetPath;
            //exit();
            return array(false,"Can not move file. Upload failed.",$targetPath);
        }
        return array(true,"Upload successful!", $targetPath);
    }
    
    
}


?>
