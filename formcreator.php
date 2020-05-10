<?php
	session_start();
    ob_start();
    
	if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }
    else if(!isset($_GET['fid']) || !isset($_GET['fname'])){
        header('location: dashboard.php');
    }

    require_once 'config.php';
    //require 'file.php';

    $userId = $_SESSION['user_id'];
    $fid = trim($_GET['fid']);
    $fid = str_replace('"','',$fid);
    $fname = trim($_GET['fname']);
    $fname = str_replace('"','',$fname);

    $fileName = $fname.strval($fid);

    //$htmlLoad = readFormFile($fileName,"html");
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <title><?php echo $fname ?> | Form Builder</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/tether.min.css" />
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/form_builder.css" />
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light  bg-faded fixed-top">
            <div class="clearfix">
                <div class="container">
                    <button style="cursor: pointer;display: none"
                        class="btn btn-info export_html mt-2 pull-right" id="save_html" fname="<?php echo $fname ?>" filename="<?php echo $fileName ?>">Save Form</button>
                    <h3 class="mr-auto"><u><strong><?php echo $fname ?></strong> - Builder Mode</u></h3>
                </div>
            </div>
        </nav>
        <br />
        <div class="clearfix"></div>    
        <div class="form_builder" style="margin-top: 25px">
            <div class="row">
                <div class="col-sm-2">
                    <nav class="nav-sidebar">
                        <ul class="nav">
                            <li class="form_bal_textfield">
                                <a href="javascript:;">Text Field <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_textarea">
                                <a href="javascript:;">Text Area <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_select">
                                <a href="javascript:;">Select <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_radio">
                                <a href="javascript:;">Radio Button <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_checkbox">
                                <a href="javascript:;">Checkbox <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_email">
                                <a href="javascript:;">Email <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_number">
                                <a href="javascript:;">Number <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_password">
                                <a href="javascript:;">Password <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_date">
                                <a href="javascript:;">Date <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_button">
                                <a href="javascript:;">Button <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-5 bal_builder">
                    <div class="form_builder_area"></div>
                </div>
                <div class="col-md-5">
                    <div class="col-md-12">
                        <form class="form-horizontal">
                            <div class="preview"></div>
                            <div style="display: none" class="form-group plain_html"><textarea rows="50"
                                    class="form-control"></textarea></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/form_builder.js"></script>
</body>

</html>