<?php
/**
 * Created by PhpStorm.
 * User: salahat
 * Date: 28/01/18
 * Time: 11:03 PM
 */

ini_set('display_errors', true);
error_reporting(E_ALL);
$path = __DIR__. '/data.txt';
if(!is_file($path)){
    exit('something went wrong. file not found ');
}
$data = file_get_contents($path);// card file

$json_data = json_decode($data,true);

/*echo '<pre>';*/
/*print_r($json_data);*/
/*echo '****************************************************';*/

if(!is_array($json_data)){
    exit('something went wrong. is not a json data');
}
/*foreach ($json_data as $index=>$item) {
// find first
    foreach ($item as $index_row => $rows) {
        $global_exit =strtolower($json_data[$index]['exit']);
        $loop_incoming =strtolower($rows['incoming']);
        if (($global_exit==$loop_incoming) and ($global_exit===$loop_incoming)) {
            print_r($rows);
        }
    }
}*/
/*foreach ($json_data as $index=>$item) {
    // find last
    foreach ($item as $index_row => $rows) {
        $global_incoming = strtolower($json_data[$index]['incoming']);
        $loop_exit =strtolower($rows['exit']);
        if (($global_incoming==$loop_exit) and ($global_incoming===$loop_exit)) {
            $is_final = false;
        }
    }
}*/
require_once __DIR__.'/task/SortData.php';
require_once __DIR__.'/task/ConvertMessages.php';
$obj = new SortData($json_data);
$obj->preparationCard();
/*print_r($obj->getData());
die;*/
foreach ($obj->getData()  as $index=>$item) {
    /*print_r($item);continue;*/
    $final  = false;
    if(isset($item['conveyance']) and !empty($item['conveyance'])){
        if(class_exists($item['conveyance'])){
            $object = new $item['conveyance']($final,$item);
            if(!$final){
                 echo '- '.$object->final_message().'<br>';
            }
            if($obj->getNumberRow()==($index+1)){
                $object = new $item['conveyance'](true,'');
                echo '- '.$object->getRow().'<br>';
            }
            unset($object);
        }
    }
/*print_r($item);*/
}