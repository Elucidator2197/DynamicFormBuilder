<?php
	session_start();
  ob_start();
  
	require_once 'config.php';
	$email=$password=$enteredPass='';
	$email_err=$login_err='';

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if (!filter_var(trim($_POST["email"], FILTER_VALIDATE_EMAIL)))
			$email_err = 'Please enter a valid email.';
		else
			$email = trim($_POST['email']);

    if(property_exists("$_POST","name"))
      $name = trim($_POST['name']);

    $enteredPass = trim($_POST['pass']);
    
    if($_POST['req'] == "SIGNIN")
    {
      if(empty($email_err))
      {
        $getdata = $pdo->prepare("SELECT `password`,`id`,`name` FROM users WHERE `email` = :email");

        $getdata -> bindParam(':email',$email);

        if($getdata->execute())
        {
          echo $getdata->rowCount();
          if($getdata->rowCount()>0)
          {
            $row = $getdata->fetch();
            $password = $row['password'];
            if($enteredPass === $password)
            {
              echo 'success';
              $_SESSION['user_id'] = $row['id'];
              $_SESSION['user_name'] = $row['name'];
              if(isset($_SESSION['user_id']))
                header('location: dashboard.php');
            }
            else
            echo '
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading">Error!</h4>
            <p class="mb-0">Incorrect password</p>
            </div>';
          }
          else{
            echo '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4 class="alert-heading">Error!</h4>
            <p class="mb-0">No accounts found with that email</p>
            </div>';
          }
        }
        else
        {
          echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4 class="alert-heading">Error!</h4>
          <p class="mb-0">Query Execution failed</p>
          </div>';
        }
      }
    }
    else if($_POST['req'] == "SIGNUP")
    {
      $getUserId = $pdo->prepare("SELECT * FROM `users` ORDER BY id DESC LIMIT 1");
      if($getUserId->execute())
        $data = $getUserId->fetch();
      $uid = $data[0]+1;
      
      try{
        $insert = $pdo->prepare("INSERT INTO users(`id`,`email`,`name`,`password`) VALUES (:id,:email,:name,:password)");

        $insert -> bindParam(':id',$uid);
        $insert -> bindParam(':name',trim($_POST['name']));
        $insert -> bindParam(':email',trim($_POST['email']));
        $insert -> bindParam(':password',trim($_POST['password']));

        $inserted = $insert->execute();
      }
      catch(PDOException $e)
      {
        $inserted = 0;
      }
      
      if($inserted == 1) {
        echo 'success';
        $_SESSION['user_id'] = $uid;
        $_SESSION['user_name'] = trim($_POST['name']);
        if(isset($uid))
          header('location: dashboard.php');
      }
    }
	}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Form creator</title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" />
  <script type="text/javascript" src="js/login.js"></script>
  <script src="js/jquery.min.js"></script>
  <style>
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
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input type='text' name='req' value="SIGNUP" hidden required>
          <h1>Create Account</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
          </div>
          <span>or use your email for registration</span>
          <input type="text" placeholder="Name" name="name" required/>
          <input type="email" placeholder="Email" name="email"/>
          <input type="password" placeholder="Password" name="password" required/>
          <button>Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input type='text' name='req' value="SIGNIN" hidden required>
          <h1>Sign in</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
          </div>
          <span>or use your account</span>
          <input type="email" name="email" c placeholder="Email" value="saatvik@gmail.com"/>
          <input type="password" name="pass" placeholder="Password" value="123"/>
          <a href="#">Forgot your password?</a>
          <button type="submit">Sign In</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p> Please login with your personal info</p>
            <button class="ghost" id="signIn" onclick="signInFun()">Sign In</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello!</h1>
            <p>Enter your personal details</p>
            <button class="ghost" id="signUp" onclick="signUpFun()">Sign Up</button>
          </div>
        </div>
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