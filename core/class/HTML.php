<?php

// Constants

// MsgBox Status related
define('MSGBOX_INFO',0);
define('MSGBOX_SUCCESS',1);
define('MSGBOX_WARNING',2);
define('MSGBOX_ERROR',3);


/**
 * \brief Generate %HTML strings easily
 * 
 * @author Shafiul Azam
 * 
 */

class HTML{
    
    /**
     * Generate a single Table Row ( <tr> element)
     * @param array $td_array | each element of the array should be a column for the Row (<td> element)
     * @return string | Generated html
     */
    
    public static function tr($td_array) {
        $str = "<tr>";
        foreach ($td_array as $i) {
            $str .= "<td>$i</td>";
        }
        $str .= "</tr>";
        return $str;
    }
    
    /**
     * Generates html for lists - ordered or unordered
     * @param array $items - 1 dimensional array of html strings- which are items of the list.
     * @param string $listType "ul" for Unordered (Bullet) list, "ol" for ordered (numbered) list.
     * @param array $attrArr key-value array, key being the attribute and value being the value for that attribute
     * @return html | generated html 
     */
    
    public static function lists($items, $listType="ul", $attrArr = null){
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<$listType $attrText> \n";
        foreach($items as $i){
            $str .= "\t <li>$i</li> \n";
        }
        $str .= "</$listType> \n";
        return $str;
    }
    
    public static function anchor($url, $text){
        return "<a href = '$url'>$text</a>";
    }


    /**
     * @name Form related
     */
    
    //@{
    
    /**
     * Generates html for an <input> element
     * @param string $name  name attribute
     * @param string $type  type attribute    
     * @param string $value value attribute
     * @param array $attrArr key-value array, key being the attribute and value being the value for that attribute
     * @return string | generated html 
     */
    
    public static function input($name, $type="text", $value="", $attrArr = null) {
        $attrText = "";
        
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        return "<input type='$type' name = '$name' value='$value' $attrText />";
    }

    /**
     * Generates html for <select> element
     * @param string $name "name" attribute
     * @param array $options key-value array for <option> elements for this select element.
     *  - key is the label for the option
     *  - value is the "value" attribute for the option
     * @param string $selectedValue "value" attribute of the <option> which will be selected by default
     * @param array $attrArr key-value array, key being the attribute and value being the value for that attribute
     * @return string | generated html
     */
    
    public static function select($name, $options, $selectedValue = "", $attrArr= null) {
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<select ";
        $str.= "$attrText name = '$name'>";
//        var_dump($options);
        foreach ($options as $displayText => $value) {
            $selected = ($value == $selectedValue) ? ("selected = 'selected'") : ("");
            $str .= "<option $selected name = '$value' value = '$value'>$displayText</option>";
        }
        $str .= "</select>";
        return $str;
    }
    


    /**
     * Generates HTML for  <textarea>
     * @param string $name "name" attribute
     * @param string $value the value for this textarea: <textarea>$value</textarea>
     * @param array $attrArr key-value array, key being the attribute and value being the value for that attribute
     * @return string | generated html 
     */
    
    public static function textarea($name,$attrArr=null,$value = ""){
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<textarea name = '$name' $attrText >$value</textarea>"; 
        return $str;
    }
    
    /**
     * A dummy form element creator. Takes all arguments like a regular html element creator 
     * but outputs nothing. May be suitable for some applications.
     * @param type $name
     * @param type $attrArr
     * @param type $value 
     */
    
    public static function dummy($name,$attrArr=null,$value=''){
        // Does nothing!
    }
    
    
//    public static function checkbox($name,$options,$value='',$attrArr=null,$breakStr = '<br />'){
//        $str = 
//    }
    
    
    //@}
    
    /**
     * Generates styled %HTML to display important messages
     * @param string $message the $HTML message to display
     * @param int $mode indicates status of the message
     *  - see constants in Funcs::messageExit() function
     * @param bool $exit if set to true, page dies (exits) after displaying the message
     * @param string $id ID attribute for the messagebox div
     * @return string | generated html
     */
    
    public static function msgbox($message, $mode = MSGBOX_SUCCESS, $exit = false, $id = ""){
        // modes: 0: info, 1: success, 2: warning, 3: error
        $str = "<br>"; 
        $base_style = "border: 1px solid; margin: 10px 0px; padding:15px 10px 15px 50px; background-repeat: no-repeat; background-position: 10px center; ";
        $color = array("00529B", "4F8A10", "9F6000", "D8000C");
        $bgcolor = array("BDE5F8","DFF2BF","FEEFB3","FFBABA");
        $bgimg = array("","","","");
        $style = $base_style . " color: #" . $color[$mode] . "; background-color: #" . $bgcolor[$mode] . "; background-image: url('" . $bgimg[$mode] . "');";
        $str .= "<div id = '$id' style = \"$style\">$message</div>";
        $str .= "<br>";
        return $str;
        if($exit){
            exit();
        }
    }
    
}
?>