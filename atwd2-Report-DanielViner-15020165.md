Avanced Topics in Web Development 2 - Report
=======
## Daniel Viner - 15020165
## All Files
1. PHP script for extracting data from CSV and creating 6 XML files:
  * [CVSExtract.php](https://github.com/DanViner/webDevFinal/blob/master/php/CSVExtract.php)
2. XML Files created by 'CSVExtract.php':
  * [brislington.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/brislington.xml)
  * [fishponds.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/fishponds.xml)
  * [newfoundland_way.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/newfoundland_way.xml)
  * [parson_st.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/parson_st.xml)
  * [rupert_st.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/rupert_st.xml)
  * [wells_rd.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/orig/wells_rd.xml)
---  
3. Script for normalising the XML data to only show NO2 values:
  * [NO2.php](https://github.com/DanViner/webDevFinal/blob/master/php/NO2.php)
4. XML Files created by 'NO2.php':
  * [brislington.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/brislington_no2.xml)
  * [fishponds.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/fishponds_no2.xml)
  * [newfoundland_way.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/newfoundland_way_no2.xml)
  * [parson_st.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/parson_st_no2.xml)
  * [rupert_st.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/rupert_st_no2.xml)
  * [wells_rd.xml](https://github.com/DanViner/webDevFinal/blob/master/xml/no2/wells_rd_no2.xml)
---  
5. HTML files for creating the graphs:
  * [scatterGraph.html](https://github.com/DanViner/webDevFinal/blob/master/graphs/scatterGraph.html)
  * [lineGraph.html](https://github.com/DanViner/webDevFinal/blob/master/graphs/lineGraph.html)
6. Script for providing a years worth of data to 'scatterGraph.html':
  * [DataOverYearJSON.php](https://github.com/DanViner/webDevFinal/blob/master/php/DataOverYearJSON.php)

All Sources and Information utalised to program are included within the headers of their relevant files.
---  
## XML Parsers: DOM VS STREAM
Both DOM and Stream parsers are utilised within the development of this assignment as their differences offer
advantages for different situations.

DOM parsers are object based, they operate by loading the entire XML file into memory for parsing, this means that
they can offer exceptional speeds when the XML files are relatively small, however in the case of this project
where the XML files are large they will exponentially use a larger amount of data. DOM parsers work by creating a DOM
tree from the entire file, which is then processed by the user. However, Stream parsers are event based, crucially these 
parsers don't store the XML as it is read. These parsers operate by triggering an event upon reaching a <tag>, parsing
the xml until it reaches an </tag>, where an end-tag event is fired.

Another difference between DOM and Stream parsers is their functionalities. DOM parsers are Read/Write, this allows
a user to edit, insert, or delete nodes. Stream parsers on the other hand are read only. DOM parsers are unique in that 
they offer backwards navigation, a user can reverse up a tree to previous nodes, whereas Stream parsers are linear in 
operation so do not offer this functionality to the user.

From the increased functionality it could be said DOM parsers are objectively better, however due to their method
for operation as stated earlier DOM parsers use a lot of memory quickly and can become very intensive. Another issue with DOM
parsers is that in some scenarios we simply do not need the functionality of the DOM parser as we are only reading data.
When we are only required to read data, it makes much more sense to implement a Stream parser as they are not only faster,
but they will in turn free up more resources for the system.

In conclusion, the choice of stream parser should be entirely decided by the context of the implantation. If a read/write is
required, use DOM parser. If we only wish to read the file, use a Stream parser.

---
## Chart and Data Visualisation:
***Scatter Graph***
I have extended the basic functionality and usability of the Scatter graph by utilising some HTML elements to ease refining
data searching, being;

  1. A drop down list to select the monitor station location.
  2. A drop down list to select the year for the query.
  3. An input box for the Time.
  
One important extension that was enabled as a result of these additions was the ability to refresh the graph without the user
having to reload the entire webpage. This also means that a single script can be used to retrieve all of the data on the page.
Another addition I made to the Scatter Graph was the inclusion of a trendline. This extension was added to improve usability
of the graph for the user, as often times a scatter graph can be difficult to read, so offering a clearly visible trendline
to track progress was an obvious addition that should be made to improve usability of the system.

---
***Line Graph***
I have extended the basic functionality and usability of the Line graph by using similar techniques and additions to the 
scatter graph. Included in this graph are:

  1. A drop down list to select the monitor station location.
  2. A html5 date selector to ease selecting dates instead of the user having to type the input.
  
These were made for the same reasons as the scatter graph to improve usability and efficiency. A trendline was also added to
this graph to offer a quick a concise result for the user to observe.
