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
//Loop 6 times to cover all outputs
for($i = 0; $i < count($output); $i++ ){
    //initialise reader, define file to read.
    $xmlReader = new reader();
    $xmlReader->open("../xml/orig/" . $input[$i]);
    
    //initialise writer, allocate memory.
    $xmlWriter = new writer();
    $xmlWriter->openMemory();
    
    //create "header"
    $xmlWriter->startDocument("1.0");
    $xmlWriter->setIndent("2");
    $xmlWriter->startElement("data");
    $xmlWriter->writeAttribute("type", "nitrogen dioxide");
    /*
     * <?xml version="1.0"?>
     * <data type="nitrogen dioxide">
     */
    //set reader to the first row
    while($xmlReader->read() && $reader->name !=="row");
    
    $location = true;
    $doc = new DOMDocument;
    
    while($xmlReader->name === "row"){
        $element = simplexml_import_dom($doc->importNode($xmlReader->expand(), 
                true));
        
        //we only need the location value once per file, only entered on the 
        //   first pass.
        //<location long="--" lat="--" id="-----">
        if($location){
            $xmlWriter->startElement("location");
            $xmlWriter->writeAttribute("id", $element->desc->attributes()->val);
            $xmlWriter->writeAttribute("lat", $element->lat->attributes()->val);
            $xmlWriter->writeAttribute("long", $element->long->attributes()
                    ->val);
            $location = false;
        }
        
        //write bulk of data
        //<reading val="--" time="--:--:--" date="--/--/----"/>
        $xmlWriter->startElement("reading");
        $xmlWriter->writeAttribute("date", $element->date->attributes()->val);
        $xmlWriter->writeAttribute("time", $element->time->attributes()->val);
        $xmlWriter->writeAttribute("val", $element->no2->attributes()->val);
        $xmlWriter->endElement();
        $xmlReader->next("row");
    }
    /*
     * </location>
     * </data>
     */
    $xlmWriter->endElement();
    $xmlWriter->endElement();
    $xmlWriter->endDocument();
    
    //create files
    file_put_contents("../xml/no2/" . $output[$i], $xmlWriter->flush(true));
    
    //not necessary, but good practice.
    $xmlReader->close();
}
?>
