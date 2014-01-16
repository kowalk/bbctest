<?php

class Input{
    /**
     * Page url
     * @staticvar string
     */              
    public static $url;
    
    
    public static $urlPath;
    /**
     * Post variables
     * @staticvar mixed
     */              
    public static $post;
    
    public static $files;
    /**
     * Cookies
     * @staticvar mixed
     */              
    public static $cookie;
    /**
     * Session variables
     * @staticvar mixed
     */              
    public static $session;
    /**
     * url params
     * @staticvar string
     */
    public static $p;
    
    /**
     * subparams
     */
    public static $s;
    
    public static $lang;
    
    public static $get;

    public static function init()
    {
        if(self::isCli()){
            self::initCli();
        }

        self::$get      = &$_GET;
        self::$session 	= &$_SESSION;
        self::$post    	= &$_POST;
        self::$cookie  	= &$_COOKIE;
        self::$files    = &$_FILES;
        self::$urlPath  = urldecode($_SERVER['REQUEST_URI']);
        self::$url	= URL_HOST.self::$urlPath;

        self::parseGet();
        self::parseFiles();

        self::$lang = self::getSubparam(0,1,'en');
    }
    
    public static function initCli(){
        Log::n('Init CLI');
        $_SERVER['SERVER_NAME'] = 'PHP_CLI';
        $_SERVER['HTTP_HOST'] = 'PHP_CLI';
        
        $argv = $_SERVER['argv'];
        $_SERVER['REQUEST_URI'] = exists($argv,1); 
        $_SERVER['SCRIPT_URI'] = $_SERVER['REQUEST_URI'];
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }
    
    public static function isCli(){
        return (PHP_SAPI === 'cli');
    }
    
    
    public static function getHost()
    {
        return URL_HOST;	
    }
    
    public static function parseFiles(){
        foreach(self::$files as &$f){
            $isFilesArray = isset($f['tmp_name']);
            
            if($isFilesArray){
                $tmpName = $f['tmp_name'];
                
                while(is_array($tmpName)){
                    $tmpName = reset($tmpName);
                }
            }
            
            if($isFilesArray){
                $f = diverse_array($f);             
            }
        }
    }
    
    public static function parseGet()
    {
        $matches = array();
        $host = "#".URL_HOST.'(.*)#';
        $allowedChars = "#[^A-Za-z0-9\.,/_-]#";
        
    	preg_match( $host, self::$url, $matches );

        //escape url
        $m = $matches[1];
        $m = explode("?",$m);
        $m = $m[0];
        $m = preg_replace($allowedChars,"",$m);
        $url = explode("/",$m);
        unset($url[0]);

        //subparams
        $params = array();
        $subparams = array();
        
        foreach($url as $param){
            $tmp = explode(",",$param);
            $subparams[] = $tmp;
            $params[] = trim( reset($tmp) );
        }
        
        //sanitize native (after ?) get params
        $nativeGet = array();
        if(!empty(self::$get)){
            foreach(self::$get as $key => $val){
                $key = trim( preg_replace($allowedChars,"",$key) );
                $val = trim_recursive( preg_replace($allowedChars,"",$val) );
                
                $nativeGet[$key] = $val;
            }
        }

        self::$p = $params;
        self::$s = $subparams;
        self::$get = $nativeGet;
    }
    
    public static function getUrlWithQuery($paramName, $paramValue){
        $url = explode("?",self::$url,2);
        
        $query = self::$get;
        $query[$paramName] = $paramValue;
        $url[1] = http_build_query($query);
        $url = join("?",$url);

        return $url;
    }
    
    public static function getParam($param,$default=null){
        $ret = exists(self::$p,$param,$default);
        return (empty($ret)) ? $default : $ret;
    }
    
    public static function getSubparam($param,$subparam,$default=null){
        $param = exists(self::$s,$param,array());
        return exists($param,$subparam,$default);
    }
    
    public static function goHome(){
        self::goUrl("");
    }
    
    public static function goUrl($url)
    {
        Log::n("THE END BY REDIRECT TO $url\n");
        if(!CMS_TEST_RUN){
            header('location: '.self::url($url));
            exit;
        }
    }
    
    private static function url($url){
        return URL_HOST.$url;
    }
    
    public static function goAuth($url=''){
        if(empty($url)){
            $url = str_replace(URL_HOST,"",self::$url);
        }
        
        $url = '/auth#'.$url;
        
        self::goUrl($url);
    }
}
?>