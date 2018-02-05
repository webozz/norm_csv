<?php

/**
 * 
 * 
 * 
 */


$output_dir = "output/";
$i=0;
$filelist=array();
$content="";
// Change this variable...
$spalte = 1;
  
//$col_name="Speed";

if( $argv[1] == "noheads" ){
  $col_name="file_without_heads";
  $src_dir = "src_noheads/";
  
}else{
  $col_name=$argv[1];
  $src_dir = "src/";
}


//$output_file = $output_dir.'output_test.txt';
$output_file = $output_dir.'output_average_'.$col_name.'.csv';
$fp = fopen($output_file,"wb");





// Open a directory, and read its contents
if (is_dir($src_dir)){
    if ($dh = opendir($src_dir)){
      while (($file = readdir($dh)) !== false){
        #echo "filename:" . $file . "\n";
        if ( $file != "." && $file != ".." && $file != ".DS_Store"){
          $filelist[$i] = $file; 
          $i++;
        }

        
      }
      closedir($dh);
    }
  }


// Loop: Run threw file list

    $i = 0;
    
    while($i < count($filelist))
    {
      $j = 0; $sum=0; $content="";

      if ( $argv[1] == "noheads" )
      {
          $current_csv = csv_to_array_noheads($src_dir.$filelist[$i]);
          //$content .= "File: ;".$filelist[$i].";";
          # Run threw lines of current csv file
          // var_dump($current_csv);
          while($j < count($current_csv))
          {
          //echo $current_csv[$j][$i];
          //  var_dump($current_csv[$j]);
          // var_dump( $current_csv[$j][$spalte]);
            $sum = $sum + $current_csv[$j][$spalte];
            $j++;
          }
            //$content .= "Average: ;". str_replace(".",",",$sum/count($current_csv)).";";
            $content .= str_replace(".",",",$sum/count($current_csv)).";";
            $content .= "\n";
      }
      else      
      {
          $current_csv = csv_to_array_heads("src/".$filelist[$i]);
          $content .= "File: ;".$filelist[$i].";";
          # Run threw lines of current csv file
          while($j < count($current_csv))
          {
            $sum = $sum + $current_csv[$j][$col_name];
            $j++;
          }
            $content .= "Average: ;". str_replace(".",",",$sum/count($current_csv)).";";
            $content .= "\n";
           
      }
    
     fwrite($fp,$content);
     $i++;

    }





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
function csv_to_array_heads($filename='', $delimiter=';')
{
    if(!file_exists($filename) || !is_readable($filename))
    return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
      while (($row = fgetcsv($handle, 10000, $delimiter)) !== FALSE)
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


function csv_to_array_noheads($filename='', $delimiter=';')
{
  $data = array();
  //echo "Hello";
  //echo file_exists($filename);
  if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
  

	
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 10000, $delimiter)) !== FALSE)
		{	
        // var_dump($row);
        $data[] = $row;
		}
		fclose($handle);
	}
	return $data;
}


?>