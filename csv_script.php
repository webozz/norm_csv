<?php

/**
 * 
 * 
 * 
 */


$src_dir = "src/";
$output_dir = "output/";
$i=0;
$filelist=array();
$content="";
// Change this variable...

//$col_name="Speed";
$col_name=$argv[1];

// echo $argv[1];

//$output_file = $output_dir.'output_test.txt';
$output_file = $output_dir.'output_average_'.$col_name.'.csv';
$fp = fopen($output_file,"wb");





// Open a directory, and read its contents
if (is_dir($src_dir)){
    if ($dh = opendir($src_dir)){
      while (($file = readdir($dh)) !== false){
        #echo "filename:" . $file . "\n";
        if ( $file != "." && $file != ".."){
          $filelist[$i] = $file; 
          $i++;
        }

        
      }
      closedir($dh);
    }
  }

// var_dump($filelist);  

// Loop: Run threw file list

    $i = 0;
    
    while($i < count($filelist))
    {
      $j = 0; $sum=0; $content="";
      $current_csv = csv_to_array("src/".$filelist[$i]);
      
      $content .= "File: ;".$filelist[$i].";";

      # Run threw lines of current csv file
      while($j < count($current_csv))
      {
        

        //$content .= $current_csv[$j][$col_name];
        //$content .= "\n";


        // Einfache Ausgabe
        //echo "Value ".$col_name.":".$current_csv[$j][$col_name]."\n";
        $sum = $sum + $current_csv[$j][$col_name];
        
        $j++;
      }

      // Output average
     // echo "Average ".$col_name.":".$average = $sum / count($current_csv);
     // echo "\n";
     
     $content .= "Average: ;". str_replace(".",",",$sum/count($current_csv)).";";
     $content .= "\n";
     // file_put_contents($output_file, $output);

     fwrite($fp,$content);



      # echo $filelist[$i]."\n";
      //echo "\n";
      $i++;
    }
  




/**
 * Example
 */

#$result =  csv_to_array($testfile);


#var_dump($result);

#echo $result[4]["Seconds"];









#var_dump($filelist);  
#var_dump($csv);

#var_dump($csv[2][0])
#echo "\n";


#echo "Test:";
#echo $csv[1][1]





### FUNCTIONS
/**
 * Convert a comma separated file into an associated array.
 * The first row should contain the array keys.
 * 
 * Example:
 * 
 * @param string $filename Path to the CSV file
 * @param string $delimiter The separator used in the file
 * @return array
 * @link http://gist.github.com/385876
 * @author Jay Williams <http://myd3.com/>
 * @copyright Copyright (c) 2010, Jay Williams
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
function csv_to_array($filename='', $delimiter=';')
{
	if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else
				$data[] = array_combine($header, $row);
		}
		fclose($handle);
	}
	return $data;
}


?>