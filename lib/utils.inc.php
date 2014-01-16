<?php 

function exists($array, $key, $default = null)
{	
	if (isset($array[$key]))
	{
		return $array[$key];
	} else {
		return $default;
	}
}

function v($var, $cont = false)
{
        if(function_exists('xdebug_call_file')){
            print xdebug_call_file().":".xdebug_call_line();
        }
	var_dump($var);
	if (!$cont) die; else echo "<hr/>"; 
}

function x($var='',$continue=false){
        if(function_exists('xdebug_call_file')){
            print xdebug_call_file().":".xdebug_call_line();
        }
	echo('<pre>');
	print_r($var);
	echo('</pre>');
	
	if($continue){
		echo('<hr/>');
	}else{
		exit();
	}
}

function instr($needle, $haystack) {
   $pos = strpos($haystack, $needle);
   return ($pos !== false);
}

function trim_recursive($val){
    if(is_array($val)){
        foreach($val as &$row){
            $row = trim_recursive($row);
        }
    }else{
        $val = trim($val);
    }
    
    return $val;
}

function strip_tags_recursive($val){
    if(is_array($val)){
        foreach($val as &$row){
            $row = strip_tags_recursive($row);
        }
    }else{
        $val = strip_tags($val);
    }
    
    return $val;
}

function array_set_keys($column_name,$src_array){
    $ret = array();
    
    foreach($src_array as $row){
        $ret[ $row[ $column_name ] ] = $row;
    }
    
    return $ret;
}

if(!function_exists('array_column')){
    function array_column($srcArray, $columnName){
        $ret = array();
        
        foreach($srcArray as $row){
            $ret = $row[ $columnName ];
        }
        
        return $ret;
    }
}

function object_to_array($d) {
    if (is_object($d)) {
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    }else {
        return $d;
    }
}

function array_to_object($d) {
    if (is_array($d)) {
        return (object) array_map(__FUNCTION__, $d);
    }else {
        return $d;
    }
}

function multi_implode($array, $glue) {
    $ret = '';

    foreach ($array as $item) {
        if (is_array($item)) {
            $ret .= multi_implode($item, $glue) . $glue;
        } else {
            $ret .= $item . $glue;
        }
    }

    $ret = substr($ret, 0, 0-strlen($glue));

    return $ret;
}

function array_interlace($arr1, $arr2){    
    reset($arr1);
    reset($arr2);
    $ret = array();
    $a1count = count($arr1);
    $a2count = count($arr2);
    
    $limit = max($a1count, $a2count);
    
    for($i = 0; $i < $limit; $i++){
        if($i < $a1count){
            $valFromA1 = array_pop($arr1);
            $ret[] = $valFromA1;
        }
        
        if($i < $a2count){
            $valFromA2 = array_pop($arr2);
            $ret[] = $valFromA2;
        }
    }

    return $ret;
}

function diverse_array($vector) { 
    $result = array(); 
    foreach($vector as $key1 => $value1){
        foreach($value1 as $key2 => $value2){ 
            $result[$key2][$key1] = $value2; 
        }
    }
    return $result; 
}

function html_entity_decode_recursive($val){
    if(is_array($val)){
        foreach($val as &$row){
            $row = html_entity_decode_recursive($row);
        }
    }else{
        $val = html_entity_decode($val, ENT_COMPAT, 'UTF-8');
    }
    
    return $val;
}

function htmlentities_recursive($val){
    if(is_array($val)){
        foreach($val as &$row){
            $row = htmlentities_recursive($row);
        }
    }else{
        $val = htmlentities($val, ENT_COMPAT, 'UTF-8');
    }
    
    return $val;
}

?>