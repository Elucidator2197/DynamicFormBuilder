<?php 
    $action = $_POST['action'];
    
    if ($action == "writeHTML"){
        $fname = $_POST['fname'];
        $fileName = $_POST['filename'];
        $html = $_POST['html'];
        $fields = $_POST['fields'];
        /*
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
        */
        echo json_encode(array("response"=>writeFormFile($fileName,$html,$fname,$fields)));
    }

    function createFile($fileName,$fileType){
        try {
            $path = getcwd()."\\forms\\".$fileName.".".$fileType;
            $myFile = fopen($path, 'w') or die("can't create file");
            fclose($myFile);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    function deleteFile($fileName,$fileType){
        try {
            $path = getcwd()."\\forms\\".trim($fileName).".".$fileType;
            $myFile = fopen($path, 'w') or die("can't open file");
            fclose($myFile);
            unlink($path) or die("Couldn't delete file");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    
    function readFormFile($fileName,$fileType){        
        try {
            echo $fileName;
            $path = getcwd()."\\forms\\".trim($fileName).'.'.$fileType;
            $myFile = fopen($path, 'r') or die("can't open file");
            $data =""; $start=0; $end=0;
            while(!feof($myFile)) {
                $temp = fgets($myFile);
                if($temp == "<!--Form Begins-->"){ $start = 1; }
                else if($temp == "<!--Form Ends-->") {$end = 1;} 
                if($fileType=="html")
                {
                    if($start==1 && $end==0)
                        $data = $data + $temp;
                }
                else {$data = $data + $temp;}
            }
            fclose($myFile);
            return $data;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    function writeFormFile($fileName,$data,$fname,$fields){        
        $post="";
        foreach($fields as $f)
        {
            $post = $post.'trim($_POST("$f"))'.'\t';
        }
        try {
            $head = '
                <!DOCTYPE html><html lang="en-US">
                <html>
                <head>
                    <title>'.$fname.' | Forms Creator</title>
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                    <link rel="stylesheet" href="../css/bootstrap.min.css" />
                    <link rel="stylesheet" href="../css/tether.min.css" />
                    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css" />
                    <style>
                        body {
                        background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
                        }
                        .wrapper {
                            background: #50a3a2;
                            background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
                            background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100vh;
                            overflow: hidden;
                        }
                        .wrapper.form-success .container h1 {
                            -webkit-transform: translateY(85px);
                                    transform: translateY(85px);
                        }

                        .bg-bubbles {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            z-index: -1;
                        }
                        .bg-bubbles li {
                            position: absolute;
                            list-style: none;
                            display: block;
                            width: 40px;
                            height: 40px;
                            background-color: rgba(255, 255, 255, 0.15);
                            bottom: -160px;
                            -webkit-animation: square 25s infinite;
                            animation: square 25s infinite;
                            -webkit-transition-timing-function: linear;
                            transition-timing-function: linear;
                        }
                        .bg-bubbles li:nth-child(1) {
                            left: 10%;
                        }
                        .bg-bubbles li:nth-child(2) {
                            left: 20%;
                            width: 80px;
                            height: 80px;
                            -webkit-animation-delay: 2s;
                                    animation-delay: 2s;
                            -webkit-animation-duration: 17s;
                                    animation-duration: 17s;
                        }
                        .bg-bubbles li:nth-child(3) {
                            left: 25%;
                            -webkit-animation-delay: 4s;
                                    animation-delay: 4s;
                        }
                        .bg-bubbles li:nth-child(4) {
                            left: 40%;
                            width: 60px;
                            height: 60px;
                            -webkit-animation-duration: 22s;
                                    animation-duration: 22s;
                            background-color: rgba(255, 255, 255, 0.25);
                        }
                        .bg-bubbles li:nth-child(5) {
                            left: 70%;
                        }
                        .bg-bubbles li:nth-child(6) {
                            left: 80%;
                            width: 120px;
                            height: 120px;
                            -webkit-animation-delay: 3s;
                                    animation-delay: 3s;
                            background-color: rgba(255, 255, 255, 0.2);
                        }
                        .bg-bubbles li:nth-child(7) {
                            left: 32%;
                            width: 160px;
                            height: 160px;
                            -webkit-animation-delay: 7s;
                                    animation-delay: 7s;
                        }
                        .bg-bubbles li:nth-child(8) {
                            left: 55%;
                            width: 20px;
                            height: 20px;
                            -webkit-animation-delay: 15s;
                                    animation-delay: 15s;
                            -webkit-animation-duration: 40s;
                                    animation-duration: 40s;
                        }
                        .bg-bubbles li:nth-child(9) {
                            left: 25%;
                            width: 10px;
                            height: 10px;
                            -webkit-animation-delay: 0s;
                                    animation-delay: 0s;
                            -webkit-animation-duration: 40s;
                                    animation-duration: 40s;
                            background-color: rgba(255, 255, 255, 0.3);
                        }
                        .bg-bubbles li:nth-child(10) {
                            left: 90%;
                            width: 160px;
                            height: 160px;
                            -webkit-animation-delay: 11s;
                                    animation-delay: 11s;
                        }
                        @-webkit-keyframes square {
                            0% {
                            -webkit-transform: translateY(0);
                                    transform: translateY(0);
                            }
                            100% {
                            -webkit-transform: translateY(-700px) rotate(600deg);
                                    transform: translateY(-700px) rotate(600deg);
                            }
                        }
                        @keyframes square {
                            0% {
                            -webkit-transform: translateY(0);
                                    transform: translateY(0);
                            }
                            100% {
                            -webkit-transform: translateY(-700px) rotate(600deg);
                                    transform: translateY(-700px) rotate(600deg);
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="wrapper">
                        <div class="container" style="z-index:2; padding-top: 5vh;">
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-6 card" style="opacity: 0.4">
                                    <div class="row" style="opacity: 1">
                                        <div class="col"><u><h2 class="display-2"><center>'.$fname.'</center></h2></u></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
            ';
            $start = '<!--Form Begins-->
                        <form action="../formsave.php" method="POST" style="z-index:10">
                            <input type="text" name="form_filename_main" value="'.$fileName.'" hidden required>
            ';
            $end = '
                        </form>
                    <!--Form Ends-->';
            $tail = '
                                        </div>
                                    </div>
                                <div class="col-3"></div>
                            </div>
                        </div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <script src="../js/jquery.min.js"></script>
                    <script src="../js/jquery-ui.min.js"></script>
                    <script src="../js/bootstrap.min.js"></script>
                </body>
                </html>
            ';

            $data = $head.$start.$data.$end.$tail;
            
            $path = getcwd()."\\forms\\".trim($fileName).".html";
            $myFile = fopen($path, 'w') or die("can't open file!");
            fwrite($myFile, $data);
            fclose($myFile);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    function writeConfigFile($fileName,$data){        
        try {
            $path = getcwd()."\\forms\\".trim($fileName).".txt";
            $myFile = fopen($path, 'w') or die("can't open file!");
            $data = $data + '\n';
            fwrite($myFile, $data);
            fclose($myFile);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    //deleteFile("testform101","html");z
    //writeFormFile("test22","works","test");
?>