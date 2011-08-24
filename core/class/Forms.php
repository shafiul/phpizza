<?php

/**
 * Description of guiForms
 * This class simply draws HTML forms for different pages
 * coded in oop way in the sense that Forms may be re-used
 * @author Shafiul Azam
 * ishafiul@gmail.com
 * Project Manager
 */
/*
 * This file is currently edited by Imran Hasan
 */
class HTMLForm extends HTML {

    private $action = '';
    private $method = 'post';
    private $target = '';
    public $onSubmit = '';
    private $componentsArr = array();
    private $submitButtonText = '';
    private $cancelButtonId = '';
    private $tableBorder = '0';
    private $tableCellSpacing = '';
    private $tableCellPadding = '';
    private $arbritaryHTML = '';
    public $fileUpload = false;
    public $id = "";
    public $submitButtonId = "";
    private $style = "";
    private $isShowButton = true;

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function getOnSubmit() {
        return $this->onSubmit;
    }

    public function setOnSubmit($onSubmit) {
        $this->onSubmit = $onSubmit;
    }

    public function getComponentsArr() {
        return $this->componentsArr;
    }

    public function setComponentsArr($componentsArr) {
        $this->componentsArr = $componentsArr;
    }

    public function getSubmitButtonId() {
        return $this->submitButtonId;
    }

    public function setSubmitButtonId($submitButtonId) {
        $this->submitButtonId = $submitButtonId;
    }

    public function getSubmitButtonText() {
        return $this->submitButtonText;
    }

    public function setSubmitButtonText($submitButtonText) {
        $this->submitButtonText = $submitButtonText;
    }

    public function getCancelButtonId() {
        return $this->cancelButtonId;
    }

    public function setCancelButtonId($cancelButtonId) {
        $this->cancelButtonId = $cancelButtonId;
    }

    public function getTableBorder() {
        return $this->tableBorder;
    }

    public function setTableBorder($tableBorder) {
        $this->tableBorder = $tableBorder;
    }

    public function getArbritaryHTML() {
        return $this->arbritaryHTML;
    }

    public function setArbritaryHTML($arbritaryHTML) {
        $this->arbritaryHTML = $arbritaryHTML;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setStyle($style) {
        $this->style = $style;
    }

    public function setEnableDefaultButton($isShow) {
        $this->isShowButton = $isShow;
    }

    // Public & private Methods
    

    public function create($htmlAfterTable="") {
        /* Created by Shafiul Azam */
        
        $fileUploadCode = ($this->fileUpload)?("enctype='multipart/form-data'"):("");
        $str = '<form class="html-form" ' . $fileUploadCode . ' method = "' . $this->method . '" action = "' . $this->action . '" target = "' . $this->target . '" onsubmit = "' . $this->onSubmit . '" id = "' . $this->id . '">';
        $str .= '<table class="html-form-table" cellspacing = "' . $this->tableCellSpacing . '" cellpadding =  "' . $this->tableCellPadding . '"  border = "' . $this->tableBorder . '"><tbody>';
        // Loop through the components and print one component per row
        foreach($this->componentsArr as $label=>$content){
        $str .= $this->tr(array($label,$content)) . "\n";
        }
        $str .= '</tbody></table><br />' . $this->arbritaryHTML . $htmlAfterTable . '<br />';
        $str .= '<input id="'. $this->submitButtonId .'" class=html-form-submit type = "submit" value = "' . $this->submitButtonText . '" />';
        $str .= '</form>';
        return $str;
    }

}

?>