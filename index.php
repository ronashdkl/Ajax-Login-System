<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: index.php
 *  @Description: Login form
 */
require_once 'core/init.php';
$user = new User();
if ($user->isLoggedIn()) {
    Redirect::to("profile.php");
}
if (Input::get('post')) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array('required' => true),
            'identity' => array('required' => true)
        ));

        if ($validate->passed()) {
            $remember = (Input::get('remember') === 'on') ? true : false;

            $login = $user->login(Input::get("identity"), Input::get("password"), $remember);
            if ($login) {
                $success = "Logging In...";
            } else {
                $error = "Sorry! Login failed";
            }
        } else {
            $errors = $validate->errors();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Basic Page Needs
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <meta charset="utf-8">
        <title>Guest Registration System</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Mobile Specific Metas
        ––––––––––––––––––––––––––––––––––s–––––––––––––––– -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FONT
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

        <!-- CSS
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">

        <!-- Favicon
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link rel="icon" type="image/png" href="images/favicon.png">
        <script src="js/jQuery-2.2.0.min.js" type="text/javascript"></script>
        <script src='js/notify.js' type='text/javascript'></script>

    </head>
    <body>
        <!-- Primary Page Layout
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <?php
        if (isset($errors)) {
            foreach ($errors as $er) {
                ?>
                <script type='text/javascript'>$.notify('<?php echo $er; ?>', 'warning');</script>
                <?php
            }
        }
        ?>
        <?php
        if (isset($success)) {
            ?>
            <script type='text/javascript'>
                $.notify('<?php echo $success; ?>', 'success');
                $("#lock").empty();

                setTimeout(function () {
                    window.location.href = 'profile.php';
                }, 1000);

            </script>
            <?php
        }
        ?>
        <?php
        if (isset($error)) {
            ?>
            <script type='text/javascript'>$.notify('<?php echo $error; ?>', 'error');</script>
            <?php
        }
        ?>
        <!-- Primary Page Layout
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <div class="container">
            <h3  style="margin-top: 1%;" class="four"><?php echo Config::get('site/name'); ?></h3>
            <p style="margin-top: -2%;"><?php echo Config::get('site/slogan'); ?></p>
            <div class="row">

                <div class="one-half column"  style=";margin-top: 5%">
                    <img alt="Login" id="lock" src="images/<?php if (!isset($success)) {
            echo "login.png";
        } else {
            echo "unlock.png";
        } ?>" style=" margin-left: -15%;float: left;"/>

                </div>


                <div class="one-half column" style="margin-top: 11%">
                    <h4>Guest Credential</h4>
                    <form action="index.php" method="post" name="post">
                        <div class="row">
                            <div class="six columns">
                                <label for="identity">Identity</label>
                                <input class="u-full-width" type="text" name="identity" placeholder="username or e-mail" id="identity">
                            </div>
                            <div class="six columns">
                                <label for="password">Password</label>
                                <input class="u-full-width" name="password" type="password" placeholder="**********" id="password">
                            </div>
                        </div>

                        <label class="example-send-yourself-copy">
                            <input type="checkbox" value="on" name="remember">
                            <span class="label-body">Remember Me</span>
                        </label>
                        <input name="token" value="<?php echo Token::generate(); ?>" type="hidden"/>
                        <input class="button-primary" type="submit" name="post"  value="Sign In">
                    </form>

                    <p>Don't have an account? Register <a href='register.php'>Here</a></p>

                </div>
            </div>
            <p style="position: absolute;margin-top: 8%;"><?php echo Config::get('site/copy'); ?></p>
        </div>

        <!-- End Document
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    </body>
</html>
