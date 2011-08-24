<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Edited By    :   Imran Hasan Hira
 *              :   imranhasanhira@gmail.com
 *              :   Core Developer
 * Page         :
 * Description  :
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */
require_once dirname(__FILE__) . '/generalFuncs.php';
db_connect();

class blocks {

    private $title = "";
    private $items = array();
    private $attrs = array();
    public $html = "";

    public function __construct($title) {
        $this->title = $title;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function setAttrs($attrs) {
        $this->attrs = $attrs;
    }

    public function generate() {
        $html = '<div class="sidemenu">
            <h3>' . $this->title . '</h3>
                <ul>';

        $html .= $this->html;
        if (isset($this->items)){
            foreach ($this->items as $k => $v){
                $attr = (isset($this->attrs[$k]))?($this->attrs[$k]):('');
                $html .= "<li><a href = '$v'" . $attr . " >$k</a></li>\n";
            }
        }
        $html .= '</ul>
            </div>';
        return $html;
    }

}

class sideBlocks {

    //put your code here

    public static function example($classBy = "cellBrand", $type = "p") {
        $bTitle = array("cellBrand" => "Manufacturer");
        $bTitle['cellNetwork'] = ($type == "p") ? ("Network / Carrier") : ("Categories");

        $block = new blocks("Select " . $bTitle[$classBy]);
        $items = array();
        $link = "cellList.html?t=$type&value=$classBy&alias=";
        $result = mysql_return_array(KEYVAL_TABLE, array('kkey', 'alias'), array('type' => $type, 'vvalue' => $classBy));
        while ($i = mysql_fetch_array($result)) {
            $items[$i['kkey']] = $link . $i['alias'];
        }
        $block->setItems($items);
        return $block->generate();
    }

    
}

?>
