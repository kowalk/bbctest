<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
define('URL_HOST', $_SERVER['HTTP_HOST']);
require 'lib/utils.inc.php';
require 'lib/input.class.php';
require 'lib/search.class.php';

Input::init();

class MainController{
    
    protected function renderTpl($tplName, $tplVars = array(), $raw = false){
        if(!$raw){
            include 'tpl/header.tpl.php';
        }
        
        include 'tpl/'.$tplName.'.tpl.php';
        
        if(!$raw){
            include 'tpl/footer.tpl.php';
        }
    }
    
    public function launchAction($action = ''){
        if(empty($action)){
            $action = exists(Input::$get, 'action', 'index');
        }
        
        $methodName = '_action'.$action;
        
        if(method_exists($this, $methodName)){
            $this->{$methodName}();
        }  else {
            $this->launchAction('404');
        }
        
    }
    
    protected function _action404(){
        header("HTTP/1.0 404 Not Found");
        $this->renderTpl('404');
    }
    
    
    protected function _actionIndex(){
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']);

        $searchResults = array();
        $phrase = exists(Input::$get, 'phrase', '');
        
        if($phrase){
            $s = new Search($phrase);
            $searchResults = $s->doSearch();
        }
        
        $tplVars = array(
            'sResults' => $searchResults,
            'phrase'  => $phrase
        );
        
        $tplName = ($isAjax) ? 'sresults' : 'index';
        $this->renderTpl($tplName, $tplVars, $isAjax);
    }
    
}


$controller = new MainController();
$controller->launchAction();
?>