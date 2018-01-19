<?php require_once('../Connections/conn.php'); ?>
<?php

mysql_connect("$hostname_conn", "$username_conn", "$password_conn");
mysql_select_db("$database_conn");

set_time_limit(0); 

function sqlAddslashes($str = '', $is_like = FALSE) 
{ 
    if ($is_like) 
    { 
        $str = str_replace('\\', '\\\\\\\\', $str); 
        }else{ 
        $str = str_replace('\\', '\\\\', $str); 
        } 
        $str = str_replace('\'', '\\\'', $str); 
        return $str; 
} 

function dumptb($table) { 
    $nline = "\n"; 
    $dp = "CREATE TABLE $table ($nline"; 
    $firstfield = 1; 
    $fields_array = mysql_query("SHOW FIELDS FROM $table"); 
     
    while ($field = mysql_fetch_array($fields_array)) 
    { 
        if (!$firstfield) 
        { 
            $dp .= ",\n"; 
        }else{ 
            $firstfield = 0; 
        } 
        $dp .= "\t".$field["Field"]." ". $field["Type"]; 
        if (isset($field['Default']) && $field['Default'] != '') 
        { 
                    $dp .= ' default \'' . sqlAddslashes($field['Default']) . '\''; 
        } 
        if ($field['Null'] != 'YES') 
        { 
            $dp .= ' NOT NULL '; 
        } 
        if (!empty($field["Extra"])) 
        { 
            $dp .= $field["Extra"]; 
        } 
    } 
    mysql_free_result($fields_array); 

    $keysindex_array = mysql_query("SHOW KEYS FROM $table"); 

    while ($key = mysql_fetch_array($keysindex_array)) 
    { 
        $kname = $key['Key_name']; 
        if ($kname != "PRIMARY" and $key['Non_unique'] == 0) 
        { 
            $kname = "UNIQUE|$kname"; 
        } 

        $index[$kname][] = $key['Column_name']; 
    } 
    mysql_free_result($keysindex_array); 
     
    while(list($kname, $columns) = @each($index)) 
    { 
        $dp .= ",\n"; 
        $colnames = implode($columns,","); 
        if($kname == 'PRIMARY') 
        { 
            $dp .= "\tPRIMARY KEY ($colnames)"; 
        }else{ 
            if (substr($kname,0,6) == 'UNIQUE') 
            { 
                $kname = substr($kname,7); 
            } 
            $dp .= "   KEY $kname ($colnames)"; 
        } 
    } 
    $dp .= "\n);\n\n"; 
    $rows = mysql_query("SELECT * FROM $table"); 
    $numfields=mysql_num_fields($rows); 
     
    while ($row = mysql_fetch_array($rows)) 
    { 
        $dp .= "INSERT INTO $table VALUES("; 
        $fieldcounter=-1; 
        $firstfield=1; 
        while (++$fieldcounter<$numfields) 
        { 
            if(!$firstfield) 
            { 
                $dp .=' , '; 
            }else{ 
                $firstfield=0; 
            } 
            if (!isset($row[$fieldcounter])) 
            { 
                $dp .= 'NULL'; 
            }else{ 
                $dp .= "'".mysql_escape_string($row[$fieldcounter])."'"; 
            } 
        } 
        $dp .= ");\n"; 
    } 
    mysql_free_result($rows); 
    return $dp; 
} 
 date_default_timezone_set( "America/Sao_Paulo" );

$data = date("d-m-Y");
$file_name = "../db/BACKUP-DB-OS-$data.txt"; 
$filehandle = fopen($file_name,'w'); 
$result = mysql_query("SHOW tables"); 
    while ($row = mysql_fetch_array($result)) 
    { 
        fwrite($filehandle,dumptb($row[0])."\n\n\n"); 
    } 
fclose($filehandle); 


require("../backup/backup_zip.php");

$file_name2 = "BACKUP-DB-VENDAS-$data"; 
$zipfile = new zipfile("$file_name2.zip");

$zipfile->addFileAndRead($file_name);

echo $zipfile->file();    

?>