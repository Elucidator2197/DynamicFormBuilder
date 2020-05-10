<?php
	  session_start();
    ob_start();
	  if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }
    
    require_once 'config.php';
    require 'file.php';
  
    $getForms = $pdo->prepare("SELECT * FROM forms WHERE `id` = :user_id");
    $getForms->bindParam('user_id',$_SESSION['user_id']);  

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if(trim($_POST['req']) == "LOGOUT"){
        session_destroy();
        header('location: index.php');
      }
      else if(trim($_POST['req']) == "INSERT"){
        $getFormId = $pdo->prepare("SELECT * FROM `forms` ORDER BY fid DESC LIMIT 1");
        if($getFormId->execute())
          $data = $getFormId->fetch();
        $fid = $data[0]+1;
      $fname = trim($_POST['fname']);

      try{
        $insert = $pdo->prepare("INSERT INTO forms(`fid`,`id`,`fname`,`fdes`) VALUES (:fid,:id,:fname,:fdes)");

        $insert -> bindParam(':fid',$fid);
        $insert -> bindParam(':fname',$fname);
        $insert -> bindParam(':id',$_SESSION['user_id']);
        $insert -> bindParam(':fdes',trim($_POST['fdes']));

        $inserted = $insert->execute();
		  }
		  catch(PDOException $e)
	  	{
	    	$inserted = 0;
      }
      
      if($inserted == 1) {
        $fileName = $fname.strval($fid);
        createFile($fileName,"html");
        createFile($fileName,"txt");
        createFile($fileName."-DATA","txt");
        header('location: formcreator.php?fid="'.$fid.'"&fname="'.$fname.'"');
      }
    }
    else if(trim($_POST["req"]) == "DELETE"){
      try{
        $delete = $pdo->prepare("DELETE FROM `forms` WHERE `fid` = :fid");

        $delete -> bindParam(':fid',trim($_POST['fid']));

        $deleted = $delete->execute();

        $fileName = $_POST['fname'].strval($_POST['fid']);

        if(!deleteFile($fileName,"txt")) $deleted = 0;
        if(!deleteFile($fileName,"html")) $deleted = 0;
        if(!deleteFile($fileName."-DATA","txt")) $deleted = 0;
		  }
		  catch(PDOException $e)
	  	{
	    	$deleted = 0;
      }
      
      if($deleted == 1) {
        header('location: dashboard.php');
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Form Creator</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css"/>
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
        z-index: 1;
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
        <div class="container" style="z-index: 2;">
            <nav class="navbar navbar-light fixed-top" style="background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);border-radius: 20px;">
                <div class="clearfix">
                    <div class="container" style="display: inline-block">
                        <h1 class="mr-auto" style="color: white;font-family: monospace;padding-top: 2vh;">Welcome <?php echo $_SESSION['user_name'] ?></h1>
                        <form class="float-right" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                          <input type='text' name='req' value="LOGOUT" hidden required>
                          <button class="nav-color-logout btn btn-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>
            <br/>
            <div style="margin-top: 15vh;">
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Form Id</th>
                        <th scope="col">Form Name</th>
                        <th scope="col">Form Description</th>
                        <th scope="col">Date of Creation</th>
                        <th scope="col">Form Link</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                      $count = 1;
                      if($getForms->execute())
                      {
                        while($data = $getForms->fetch())
                        {
                          $form = $data['fname']."".strval($data['fid']);
                          echo "<tr scope='row'>";
                          echo "<td>".$count."</td>";
                          echo "<td>".$data['fname']."</td>";
                          if($data['fdes']!=NULL)
                            echo "<td>".$data['fdes']."</td>";
                          else
                            echo "<td> ~No Description </td>";
                          echo "<td>".$data['date']."</td>";
                          echo "<td><a href='./forms/".$form.".html' target='_blank'>./form/".$form.".html</a></td>";
                          echo "<td>
                          <form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='POST'>
                            <input type='text' name='req' value='DELETE' hidden required>
                            <input type='text' name='fid' value='".$data['fid']."' hidden required>
                            <input type='text' name='fname' value='".$data['fname']."' hidden required>
                            <button class='btn btn-danger' onclick=''>Delete</button> <a href='formcreator.php?fid=".$data['fid']."'>
                          </form>
                          <button class='btn btn-primary'>Edit</button></a></td>";
                          echo "</tr>";
                          $count+=1;
                        }    
                      } 
                    ?>
                    <tr scope="row">
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                      <input type='text' name='req' value="INSERT" hidden required>
                      <td>#</td>
                      <td><input type="text" class="form-control" name="fname" placeholder="Form Name" required></td>
                      <td><input type="text" class="form-control" name="fdes" placeholder="Form Description"></td>
                      <td>N/A</td>
                      <td>N/A</td>
                      <td>
                        <button class='btn btn-primary' type="submit">Create Form</button>
                      </td>
                      </form>
            </tr>
                </tbody>
                </table>
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
  </body>
</html>