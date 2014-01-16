<?php
class Search{
    protected $feedUrl =  "http://www.bbc.co.uk/iplayer/ion/searchextended/search_availability/iplayer/service_type/radio/format/json/q/#!phrase!#/perpage/10";
    protected $phrase;
    public function __construct($phrase, $page = 1) {
        $this->phrase = $phrase;
        $this->page = $page;
    }
    
    public function doSearch(){
        $this->phrase = str_replace('/', "", $this->phrase);
        $searchUrl = str_replace("#!phrase!#", $this->phrase, $this->feedUrl);
        
        $resultJson = file_get_contents($searchUrl);
        
        return json_decode($resultJson, true);
    }
    
}
?>