<?php
/*
 * Original Author: Prakash Chatterjee
 * Original Function created singular xml file depending on input.
 * 
 * Edited By: Daniel Viner
 * Date Edited: 13/03/2018
 * Edited to use a select statement to create all of the initial
 * XML files sequentially.
 * 
 * 
 * Notes:
 * Could work faster and more efficiently
 * isn't technically divide and conquer method.
 */
 
/*
 * Stores data in format:
 * <row id="" count="">
 *      <id=val""/>
 *      <desc val=""/>
 *      <date val=""/>
 *      <time val=""/>
 *      <nox val=""/>
 *      <no val= ""/>
 *      <no2 val=""/>
 *      <lat val=""/>
 *      <long val=""/>
 * </row>
 */
//check the csv is where it should be
//Edited to kill the script if not present
if(!file_exists("../air_quality.csv")){
    die("air_quality.csv not present in project.");
}
//alot more execution time, script can take awhile depending on the machine
//alot of time added to enable use of script on UWE computers.
ini_set('max_execution_time', 300);
echo nl2br("working .. wait \r\n");
ob_flush();
flush();

//Array for output file names & corresponding IDs within the CSV file.
$outputNames = array("brislington.xml", "fishponds.xml", "parson_st.xml", 
    "rupert_st.xml", "wells_rd.xml", "newfoundland_way.xml");
$ids = array(3, 6, 8, 9, 10, 11);
/*
 * i = area = id
 * 0 = brislington = 3
 * 1 = fishponds = 6
 * 2 = parson_st = 8
 * 3 = rupert_st = 9
 * 4 = wells_rd = 10
 * 5 = newfoundland_way = 11
 */
 
//check the files havent already been created.
if(file_exists("../xml/orig/".$outputNames[0])){
    die("Files have already been created.");
}
//value of 'i' is always relational to the file names and ids
for($i = 0; $i <= 5; $i++){
    if (($handle = fopen("air_quality.csv", "r")) !== FALSE) {
        
    //initialise variables
	$header = array('id', 'desc', 'date', 'time', 'nox', 'no', 'no2', 'lat',
            'long');
	$cols = count($header);
	fgetcsv($handle);
	$count = 1;
	$row = 2;
        $out = '<records>';
	
        //loop over every entry in the csv store those that match the current id
	while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[0] == $ids[$i]) {
			$rec = '<row count="' . $count . '" id="' . $row . '">';
		
			for ($c=0; $c < $cols; $c++) {
				$rec .= '<' . trim($header[$c]) . ' val="' . 
                                        trim($data[$c]) . '"/>';
			}
			$rec .= '</row>';
			$count++;
			$out .= $rec;
		}
		$row++;
        }
	$out .= '</records>';
	
	//write output to the corresponding file matching the ID.
	file_put_contents("../xml/orig/" . $outputNames[$i], $out);
        echo nl2br("File " . $outputNames[$i] . " Created.\r\n");
    }

    fclose($handle);
}
echo nl2br("....all done!");
?>