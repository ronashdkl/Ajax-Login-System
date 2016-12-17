<?php
require_once 'core/init.php';
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: Profile.php
 *  @Description: Logged In user profile. 
 */


$user = new User();
if (!$user->isLoggedIn()) {

    Redirect::to("index.php");
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
                }, 4000);

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

                <div class="one-half column"  style=";margin-top: 6%">
                    <img alt="Login" id="lock" src="images/userprofile.png" style=" margin-top:11%;float: left;"/>

                </div>


                <div class="one-half column" style="margin-top: 11%">
                    <h4>Welcome <?php echo $user->data()->username . "!"; ?></h4>
                    <hr>
                    <div class="row">
                        <div class="one-half column">
                            <a class="button " href="update.php">Update Profile</a>

                            <br>

                            <a class="button " href="update.php?changepassword=<?php echo Hash::unique(); ?>">Change Password</a>
                            <a  class="button " href="logout.php">Sign Out</a>


                        </div>
                        <div class="one-halfcolumn">
                            <p>
                                Name: <?php echo $user->data()->full_name; ?><br>
                                Contact:  <?php echo $user->data()->contact; ?><br>
                                E-mail:  <?php echo $user->data()->email; ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <p style="position: absolute;margin-top: 15%;"><?php echo Config::get('site/copy'); ?></p>
        </div>

        <!-- End Document
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    </body>
</html>
