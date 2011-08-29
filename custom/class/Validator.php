<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager, 
 *              :   PROGmaatic Developer Network
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

/**
 * \define Your custom validation functions
 * 
 * @author Shafiul Azam
 * @author Put your name here!
 */

class Validator extends CoreValidator {
    // Put your custom validation functions here
    
    /**
     * Checks if $this->subject is one of the values specified by $possibleValues
     * @param string $possibleValues all the possible values here, seperated by a colon ":" character (without the quotes)
     *  -   example: "enum,male:female" means $this->subject should be either "male" or "female"
     *  -   If you have some value which itself has colon (:) in it, escape all colons with a preceeding slash (\)
     * @return boolean | false if validation fails 
     */
    
    public function enum($possibleValues){
        // Handle escaped
        $possibleValues = str_replace("\:", "-_-_-", $possibleValues);
        // Get arrays for possible values
        $possibleValuesArr = explode(":", $possibleValues);
        // Handle escaped
        $values = array();
        foreach($possibleValuesArr as $i)
            $values[] = str_replace ("-_-_-", ":", $i);
        if(!in_array($this->subject, $values)){
            $this->errorArray[] = "is not a valid value";
            return false;
        }
        return true;
    }
    
}

?>
