<?php
$action = $_POST['action'];
    
    if ($action == "writeHTML"){
        $fname = $_POST['fname'];
        $fileName = $_POST['filename'];
        $html = $_POST['html'];
        $fields = $_POST['fields'];
        $fields = explode($fields);
        $cols = "";
        require_once 'config.php';

        try
        {
        foreach($fields as $f)
            if($cols=="")
                $cols = $f." "."VARCHAR(255)";
            else
                $cols = $cols.",".$f." "."VARCHAR(255)";
        $saveForm = $pdo->prepare("CREATE TABLE :tablename (".$cols.")");
        $saveForm->bindParam(':tablename',$filename);
        $saveForm->execute();
        }
        catch(Exception $e)
        { echo "ERROR";}
?>