<?php
require_once "api/validations.php";
date_default_timezone_set('EST');
session_start();
if(!empty($_SESSION["loggedIn"])){
    header("Location: ui/dashboard.php");
}
else if(isset($_POST['username']) && isset($_POST['password'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $addUser = addUser($username, $password);
    if($addUser != "Wrong Credentials" || $addUser != "Unable to add user"){
        ?>
        <script>alert("Registered"); window.location.href="http://serenity.ist.rit.edu/~dc6288/EMS/login.php"</script>
        <?php
    }
    else{
        ?>
        <script>alert("Unable to register");</script>
        <?php
    }
}
?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="ui/css/login.css">

<div class="container-fluid">
    <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto">
                            <h3 class="login-heading mb-4">Sign Up!</h3>
                            <form method="POST">
                                <div class="form-label-group">
                                    <input type="text" id="inputName" class="form-control" placeholder="Username" name="username" required autofocus>
                                    <label for="inputName">Username</label>
                                </div>
                                
                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Password"name="password" required>
                                    <label for="inputPassword">Password</label>
                                </div>
                                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>