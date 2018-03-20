<?php
/*
 * Author: Daniel Viner - 15020165
 * Desc: Extracts relevant data from original XML files and writes new XML files
 * Notes: Only works if expected files are where they should be.
 *        
 * Sources: https://blogs.msdn.microsoft.com/mfussell/2005/02/12/combining-the-reader-and-writer-classes-for-simple-streaming-transformations/
 *          https://stackoverflow.com/questions/21065150/php-reader-read-edit-node-write-writer
 *          https://www.w3schools.com/xml/xml_parser.asp
 * 
 */
/*
 * FINAL DATA FORMAT:
 * <?xml version="1.0"?>
 * <data type="nitrogen dioxide">
 *      <location long="--" lat="--" id="-----">
 *          <reading val="--" time="--:--:--" date="--/--/----"/>
 *           ...
 *          <reading val="--" time="--:--:--" date="--/--/----"/> 
 *      </location>
 * </data>
 */
 
//define input and output file names.
$input = array("brislington.xml", "fishponds.xml", "parson_st.xml", 
    "rupert_st.xml", "wells_rd.xml", "newfoundland_way.xml");
$output = array("brislington_NO2.xml", "fishponds_NO2.xml", "parson_st_NO2.xml", 
    "rupert_st_NO2.xml", "wells_rd_NO2.xml", "newfoundland_way_NO2.xml");
//six files, so we loop six times.
for($i = 0; $i < count($output); $i++ ){
    //initialise reader, define file to read.
    $reader = new reader();
    $reader->open("../xml/orig/" . $input[$i]);
    
    //initialise writer, allocate memory.
    $writer = new writer();
    $writer->openMemory();
    
    //create "header"
    $writer->startDocument("1.0");
    $writer->setIndent("2");
    $writer->startElement("data");
    $writer->writeAttribute("type", "nitrogen dioxide");
    /*
     * <?xml version="1.0"?>
     * <data type="nitrogen dioxide">
     */
    //set reader to the first row
    while($reader->read() && $reader->name !=="row");
    
    $location = true;
    $doc = new DOMDocument;
    
    while($reader->name === "row"){
        $element = simplexml_import_dom($doc->importNode($reader->expand(), 
                true));
        
        //we only need the location value once per file, only entered on the 
        //   first pass.
        //<location long="--" lat="--" id="-----">
        if($location){
            $writer->startElement("location");
            $writer->writeAttribute("id", $element->desc->attributes()->val);
            $writer->writeAttribute("lat", $element->lat->attributes()->val);
            $writer->writeAttribute("long", $element->long->attributes()
                    ->val);
            $location = false;
        }
        
        //write bulk of data
        //<reading val="--" time="--:--:--" date="--/--/----"/>
        $writer->startElement("reading");
        $writer->writeAttribute("date", $element->date->attributes()->val);
        $writer->writeAttribute("time", $element->time->attributes()->val);
        $writer->writeAttribute("val", $element->no2->attributes()->val);
        $writer->endElement();
        $reader->next("row");
    }
    /*
     * </location>
     * </data>
     */
    $writer->endElement();
    $writer->endElement();
    $writer->endDocument();
    
    //create files
    file_put_contents("../xml/no2/" . $output[$i], $writer->flush(true));
    
    //not necessary, but good practice.
    $reader->close();
}
?>