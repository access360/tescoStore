<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * TheBizzTech
 *
 * An open source library built for Codeigniter to read CSV files into associated arrays
 *
 * @author      Jason Michels
 * @link        http://thebizztech.com
 */
 
class Getcsv {
 
    function get_csv_assoc_array($file_path, $questions)
    {
        $row = 0;
        if (($handle = fopen($file_path, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, "", ",")) !== FALSE)
            {
                if($row == 0)
                {
                    foreach ($questions as $key => $value)
                    {
                        foreach($data as $d_key => $d_value)
                        {
                            if($data[$d_key] == $value)
                            {
                                $q_location[$value] = $d_key;
                            }
                        }
                    }
                }
                else
                {
                    foreach ($questions as $key => $value)
                    {
                        $new_row = $row -1;
                        $final_array[$new_row][$value] = $data[$q_location[$value]];
                    }
                }
 
                $row++;
            }
            fclose($handle);
        }
        return $final_array;
 
    }
}
 