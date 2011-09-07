<?php

/**
 * \brief File operations made-easy
 * 
 * @author Shafiul Azam
 * 
 * WARNING: CODES IN THIS FILE MIGHT BE BUGGY, NOT TESTED YET BY THE PROGRAMMER.
 */

class Files{
    
    
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
    
    public function upload($name, $targetDir, $targetFileName=null, $sizeLimit=false, $mimeTypeArr=null) {
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
    
    
}


?>
