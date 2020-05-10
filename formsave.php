<?php 
    require_once("config.php");
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                  $fileName = trim($_POST['form_filename_main']);
                    /*
                    $fields = array_keys($_POST);
                    $vals = "";
                    $cols = "";

                    foreach($fields as $f)
                        if($cols=="")
                            $cols = "`".$f."`";
                        else
                            $cols = $cols.",`".$f."`";

                    foreach($_POST as $f)
                        if($vals=="")
                            $vals = '"'.$f.'"';
                        else
                            $vals = $vals.',"'.$f.'"';
                    try{
                        $insert = $pdo->prepare("INSERT INTO forms(".$cols.") VALUES (".$vals.")");
                        $inserted = $insert->execute();
                          }
                          catch(PDOException $e)
                        {
                            $inserted = 0;
                      }*/
                    
                    $path = getcwd()."\\forms\\".trim($fileName)."-DATA.txt";
                    $myFile = fopen($path, "a") or die("can\'t open file!");
                    $data = implode(", ",$_POST);
                    //$i=0;
                    //$fields = array_keys($_POST);
                    //foreach($_POST as $f)
                        //if($f!=$fileName)
                      //      $data = $fields[$i]." => ".$f.", ";
                    //    $i+=1;
                    fwrite($myFile, $data."\n");
                    fclose($myFile);
                    return true;
                }
?>