<?php
/*
 * Author: Daniel Viner
 * Date : 15/03/2018
 * Desc: Script for retreiving data from a specific location, at a specific time
 *       over the course of a year.
 * 
 * Sources: https://www.w3schools.com/js/js_ajax_asp.asp
 *          https://www.w3schools.com/xml/ajax_xmlhttprequest_send.asp
 *          https://stackoverflow.com/questions/17662441/showing-google-chart-dynamically-in-div-using-php-and-ajax
 *          https://www.w3schools.com/js/js_json_intro.asp
 *          http://php.net/manual/en/book.simplexml.php
 */
//Get required parameters.
$location = $_REQUEST["location"];
$time = $_REQUEST["time"];
$date = $_REQUEST["date"];


//load specified xml, perform Xpath query
$xml = simplexml_load_file($location);
$results = $xml->xpath("//reading[@time='$time' and contains(@date, '$date')]");
//create arrays for data to be stored.
$rows = array();
$table = array();
$table["cols"] = array(array("label" => "date/time", "type" => "date"),
        array("label" => "NO2", "type" => "number"));
//define date format.
$dFormat = "d/m/Y H:i:s";
//loops for every result recieved.
foreach($results as $single){
    //read in the values, define date against format.
    $read = simplexml_load_string($single->asXML());
    $date = DateTime::createFromFormat($dFormat, ($read->attributes()->date 
            . " " . $read->attributes()->time));
    $val = $read->attributes()->val;
    
    //format date / time.
    $temp = array();
    $chartJSONDate = "Date(" . date("Y", $date->format("U")) . ", " 
                          . date("m", $date->format("U")) . ", " 
                          . date("d", $date->format("U")) . ", " 
                          . date("H", $date->format("U")) . ", " 
                          . date("i", $date->format("U")) . ", " 
                          . date("s", $date->format("U")) . ")";
    
    //move data.
    $temp[] = array("v" => $chartJSONDate);
    $temp[] = array("v" => abs($val));
    $rows[] = array("c" => $temp);
}
//finalise data.
$table["rows"] = $rows;
$tJSON = json_encode($table);
//return data
echo $tJSON;
?>