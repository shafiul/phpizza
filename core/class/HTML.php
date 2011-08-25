<?php
class HTML{
    public function tr($td_array, $directPrint = false) {
        $str = "<tr>";
        foreach ($td_array as $i) {
            $str .= "<td>$i</td>";
        }
        $str .= "</tr>";
        if ($directPrint)
            echo $str;
        else
            return $str;
    }
    
    public function input($name, $type="text", $id="", $value="", $attrArr = null) {
        // generate ID
        $id = (empty($id)) ? ($name) : ($id);
        $attrText = "";

        if (isset($attrArr['class']))
            $attrArr['class'] .= ' roundborder';
        else
            $attrArr['class'] = ' roundborder';
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        return "<input id='$id' type='$type' name = '$name' value='$value' $attrText />";
    }

    public function select($name, $option, $selectedValue = "", $attrArr= null, $id=null) {
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<select ";
        if ($id)
            $str .= " id='$id' ";
        $str.= "$attrText name = '$name'>";
        //var_dump($option);
        foreach ($option as $displayText => $value) {
            $selected = ($value == $selectedValue) ? ("selected = 'selected'") : ("");
            $str .= "<option $selected name = '$value' value = '$value'>$displayText</option>";
        }
        $str .= "</select>";
        return $str;
    }
    
    public function textarea($name,$value = "",$attrArr=null, $id= ""){
        $attrText = "";
        if ($attrArr) {
            foreach ($attrArr as $k => $v)
                $attrText .= "$k = '$v' ";
        }
        $str = "<textarea name = '$name' id = '$id' $attrText >$value</textarea>"; 
        return $str;
    }
    
    
    public function msgbox($message, $mode = 1, $exit = false, $id = ""){
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