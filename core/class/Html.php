<?php

// Constants
// MsgBox Status related
define('MSGBOX_INFO', 0);
define('MSGBOX_SUCCESS', 1);
define('MSGBOX_WARNING', 2);
define('MSGBOX_ERROR', 3);

/**
 * \brief Generate %HTML strings easily
 * 
 * @author Shafiul Azam
 * 
 */
class Html {

    /**
     * Generate a single Table Row ( <tr> element)
     * @param array $td_array | each element of the array should be a column for the Row (<td> element)
     * @return string | Generated html
     */
    public static function tr($td_array, $type='tr') {
        $str = '<' . $type . '>';
        foreach ($td_array as $i) {
            $str .= "<td>$i</td>";
        }
        $str .= '</' . $type . '>';
        return $str;
    }

    public static function table($data, $attrArr=null, $insertTh=true) {
        $attrText = '';
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = '<table ' . $attrText . ' >';
        if ($insertTh) {
            foreach ($data[0] as $cell)
                $str .= '<th>' . $cell . '</th>';
            unset($data[0]);
        }
        foreach ($data as $row) {
            $str .= '<tr>';
            foreach ($row as $cell)
                $str .= '<td>' . $cell . '</td>';
            $str .= '</tr>';
        }
        $str .= '</table>';
        return $str;
    }

    /**
     * Generates html for lists - ordered or unordered
     * @param array $items - 1 dimensional array of html strings- which are items of the list.
     * @param string $listType "ul" for Unordered (Bullet) list, "ol" for ordered (numbered) list.
     * @param array $attrArr key-value array, key being the attribute and value being the value for that attribute
     * @return Html | generated html 
     */
    public static function li($items, $listType="ul", $attrArr = null) {
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<$listType $attrText> \n";
        foreach ($items as $i) {
            $str .= "\t <li>$i</li> \n";
        }
        $str .= "</$listType> \n";
        return $str;
    }

    public static function a($url, $text) {
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
        $str.= "$attrText name = '$name'";
//        var_dump($options);
//        print_r($selectedValue);
//        exit();
        if (is_array($selectedValue)) {
            $str .= ' multiple="multiple" >';
            foreach ($options as $value => $displayText) {
                $selected = (in_array($value, $selectedValue)) ? ("selected = 'selected'") : ("");
                $str .= "<option $selected name = '$value' value = '$value'>$displayText</option>";
            }
        } else {
            $str .= '>';
            foreach ($options as $value => $displayText) {
                $selected = ($value == $selectedValue) ? ("selected = 'selected'") : ("");
                $str .= "<option $selected name = '$value' value = '$value'>$displayText</option>";
            }
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
    public static function textarea($name, $attrArr=null, $value = "") {
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
    public static function dummy($name, $attrArr=null, $value='') {
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
    public static function msgbox($message, $mode = MSGBOX_SUCCESS, $exit = false, $id = "") {
        // modes: 0: info, 1: success, 2: warning, 3: error
        $classes = array('msg_info', 'msg_success', 'msg_warning', 'msg_error');
        $str = '<div id = "$id" class="' . $classes[$mode] . '" >' . $message . '</div>';
        $str .= '<br />';
        return $str;
        if ($exit) {
            exit();
        }
    }

    /**
     * Call this function inside your code (controller or view) to create an %HTML div element - which user 
     * can hide or show by clicking a title.
     * 
     * @param string $title heading of the div, also a link to click to toggle visibility   
     * @param string $content   %HTML content of the div
     * @param bool $initiallyVisible if false, the %HTML content is initially hidden. $title is always visible
     * @param string $divId ID attribute for the div
     * @param string $titleType %HTML to wrap the $title
     * @return string   Generated %HTML string for the toggable div (with $title as heading) 
     */
    public static function toggleDiv($title, $content, $initiallyVisible = false, $divId = "", $titleType = "h4") {
        $display = ($initiallyVisible) ? ("block") : ("none");
        $divId = ($divId) ? ($divId) : ("tdiv-" . rand());

        $html = "<$titleType title = 'Click to expand' onclick = \"$('.toggledDivs').hide(); $('#$divId').toggle();\" style = 'cursor:pointer; color:#817339;'>$title</$titleType>";
        $html .= "<div style = 'display:$display;' class = 'toggledDivs' id = '$divId'>";
        $html .= "$content</div><br />";
        return $html;
    }

}

?>