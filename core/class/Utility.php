<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

class Utility{
    
    public function fileUpload($name, $targetDir, $targetFileName=null, $sizeLimit=false, $mimeTypeArr=null) {
        // file upload processing! $name is the NAME attribute of the <input> tag.
        // If $targetFileName is provided, that name will be used when saving the uploaded file
        // otherwise original name will be used while saving the uploaded file.
        // RETURNS FALSE FOR SUCCESSFUL UPLOAD, OTHERWISE AN ERROR MESSAGE.
        //error checking
        if ($_FILES[$name]["size"] <= 0)
            return array(true,"NIL");   // No file selected -- no upload!
        if ($_FILES[$name]["error"] > 0)
            return array(false,$_FILES["file"]["error"]);
        // size check
        if ($sizeLimit && ($_FILES[$name]["size"] > $sizeLimit))
            return array(false,"File to large, max limit is $sizeLimit bytes");
        // MIMETYPE CHECK
        if (!empty($mimeTypeArr)) {
            if (!in_array(strtolower($_FILES[$name]["type"]), $mimeTypeArr))
                return array(false,"This type of file (" . $_FILES[$name]['type'] . ") is not allowed for upload.");
        }
        // ALLOWED FOR UPLOAD. GENERATE TARGET FILE PATH
        if (!$targetFileName)
            $targetFileName = basename($_FILES[$name]['name']);
        $targetPath = $targetDir . $targetFileName;
        // UPLOAD
        if (move_uploaded_file($_FILES[$name]['tmp_name'], $targetPath)) {
            // CHMOD
            chmod($targetPath, 0755);
        } else {
            //echo $_FILES[$name]['tmp_name'] . ":" . $targetPath;
            //exit();
            return array(false,"Can not move file. Upload failed.");
        }
        return array(true,"Upload successful!");
    }
    
    public function log_error($error, $tag = "") {
        
    }
}


?>
