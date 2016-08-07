<?php
include_once '../conf/Configration.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Delivary">
        <meta name="author" content="Seif Abaza">
        <link rel="shortcut icon" href="img/favicon.png">
        <?php
        $AppName = SystemVariable(FILED_SYSTEM_APPLICATION_NAME);
        echo '<title>' . $AppName . '</title>';
        ?>


        <!-- Bootstrap CSS -->    
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <!--external css-->
        <!-- font icon -->
        <link href="css/elegant-icons-style.css" rel="stylesheet" />
        <link href="css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            header("location: home.php");
        }
        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            if ($_POST['username'] == 'Abaza' && $_POST['password'] == 'Abaza') {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = 'Abaza';
                header("location: home.php");
            } else {
                unset($_SESSION["username"]);
                unset($_SESSION["password"]);
            }
        }
        ?>
    </head>

    <body class="login-img3-body">

        <div class="container">

            <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">        
                <div class="login-wrap">
                    <p class="login-img"><i class="icon_lock_alt"></i></p>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon_profile"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <!--                    <label class="checkbox">
                                            <input type="checkbox" value="remember-me"> Remember me
                                            <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
                                        </label>-->
                    <button class="btn btn-primary btn-lg btn-block" name="login" type="submit">Login</button>
                    <!--<button class="btn btn-info btn-lg btn-block" type="submit">Signup</button>-->
                </div>
            </form>

        </div>
    </body>
</html>
