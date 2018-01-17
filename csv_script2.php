<?php

/**
 * 
 * 
 * 
 */


$dir = "src/";
$i=0;
$filelist=array();
// Change this variable...
$col_name="RPM";


// Open a directory, and read its contents
if (is_dir($dir)){
    if ($dh = opendir($dir)){
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
      $j = 0; $sum=0;
      $current_csv = csv_to_array("src/".$filelist[$i]);
      
      # Run threw lines of current csv file
      while($j < count($current_csv))
      {
        echo "Value ".$col_name.":".$current_csv[$j][$col_name]."\n";
        
        $sum = $sum + $current_csv[$j][$col_name];
        
        $j++;
      }

      echo "Average ".$col_name.":".$average = $sum / count($current_csv);
      echo "\n";
      //echo "END OF FILE\n";

      
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