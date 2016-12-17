<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: Update.php
 *  @Description: Update the user records.
 */
require_once 'core/init.php';
$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to("index.php");
}

if (empty(Input::get('changepassword')) && Input::get('changepassword') != 'yes') {
    if (Input::exists()) {
        if (Token::check(Input::get("token"))) {
            if (Hash::make(Input::get("password"), $user->data()->salt) == $user->data()->password) {
                $validate = new Validate();
                $validate = $validate->check($_POST, array(
                    'username' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'nospace' => true,
                        'alphanumeric' => true,
                    ),
                    'full_name' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'realname' => TRUE
                    ),
                    'email' => array(
                        'required' => true,
                        'max' => 30
                    ),
                    'contact' => array(
                        'required' => true,
                        'min' => 7,
                        'max' => 14,
                        'phone' => true
                    ),
                ));
                if ($validate->passed()) {
                    // reigster user


                    try {
                        $user->update(Input::get('id'), array(
                            'full_name' => Input::get('full_name'),
                            'contact' => Input::get('contact'),
                            'username' => Input::get('username'),
                            'email' => Input::get('email'),
                        ));
                        $success = "Successfully Updated!";
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    // output errors
                    $errors = $validate->errors();
                }
            } else {
                $errors[] = "Wrong Password!";
            }
        }
    }
} else {
    if (Input::exists()) {
        if (Token::check(Input::get("token"))) {
            if (Hash::make(Input::get("password"), $user->data()->salt) == $user->data()->password) {
                $validate = new Validate();
                $validate = $validate->check($_POST, array(
                    'new_password' => array(
                        'required' => true,
                        'min' => 6,
                        'matches' => 'confirm_password'
                    ),
                    'confirm_password' => array(
                        'required' => true,
                    ),
                ));
                if ($validate->passed()) {
                    // reigster user


                    try {
                        $user->update(Input::get('id'), array(
                            'password' => Hash::make(Input::get('new_password'), $salt),
                        ));
                        $success = "Successfully Changed!";
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    // output errors
                    $errors = $validate->errors();
                }
            } else {
                $errors[] = "Wrong Password!";
            }
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
    foreach ($errors as $error) {
        ?>
                <script type='text/javascript'>$.notify('<?php echo $error; ?>', 'warning');</script>
    <?php
    }
}
?>
<?php
if (isset($success)) {
    ?>
            <script type='text/javascript'>$.notify('<?php echo $success; ?>', 'success');
                setTimeout(function () {
                    window.location.href = 'profile.php';
                }, 2000);

            </script>
    <?php
}
?>
        <div class="container">
            <h3  style="margin-top: 1%;" class="four"><?php echo Config::get('site/name'); ?></h3>
            <p style="margin-top: -2%;"><?php echo Config::get('site/slogan'); ?></p>
            <div class="row">

                <div class="one-half column" style=";margin-top: 5%">
                    <img alt="Login" src="images/userprofile.png" style=" margin-top: 15%;float: left;"/>
                </div>


                <div class="one-half column" style="margin-top: 10%">


        <?php if (empty(Input::get('changepassword')) && Input::get('changepassword') != 'yes') {
            ?>
                        <h4>Update Profile</h4>
                        <form name="post" action="update.php" method="post">
                            <div class="row">
                                <div class="six columns">
                                    <label for="full_name">Full Name</label>
                                    <input value="<?php echo $user->data()->full_name; ?>" class="u-full-width" type="text" name="full_name" placeholder="Eg: Ronash Dhakal" id="fullname">
                                </div>
                                <div class="six columns">
                                    <label for="contact">Contact</label>
                                    <input value="<?php echo $user->data()->contact; ?>" class="u-full-width" type="text" name="contact" placeholder="Eg: 9841131037" id="contact">
                                </div>
                            </div>
                            <div class="row">
                                <div class="six columns">
                                    <label for="username">Username</label>
                                    <input value="<?php echo $user->data()->username; ?>" class="u-full-width" type="text" name="username" placeholder="username or e-mail" id="username">
                                </div>
                                <div class="six columns">
                                    <label for="email">E-mail</label>
                                    <input value="<?php echo $user->data()->email; ?>" class="u-full-width" type="email" name="email" placeholder="example@ronash.com.np" id="email">
                                </div>
                            </div>

                            <div class="row">
                                <div class="six columns">
                                    <label for="password">Current Password</label>
                                    <input  class="u-full-width" name="password" type="password" placeholder="**********" id="password">
                                </div>
                                <div class="six columns">
                                    <label for="password">Change Password</label>
                                    <a class="button " onclick="javascript:return confirm('It will not save your edited data, Do you really want to abort it and change  password?')" href="update.php?changepassword=<?php echo Hash::unique(); ?>">Change Password</a>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $user->data()->id; ?>"/>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>

                            <input class="button-primary" name="post" type="submit"  value="Update"> <a class="button" href="profile.php">Go Back</a>
                        </form>

<?php } else { ?>
                        <h5>Change Password for <?php echo $user->data()->full_name; ?></h5>
                        <form name="post" action="update.php?changepassword=<?php echo Hash::unique(); ?>" method="post">

                            <div class="row">
                                <div class="six columns">
                                    <label for="password">New Password</label>
                                    <input  class="u-full-width" name="new_password" type="password" placeholder="**********" id="new_password">
                                </div>
                                <div class="six columns">
                                    <label for="password">Confirm Password</label>
                                    <input  class="u-full-width" name="confirm_password" type="password" placeholder="**********" id="confirm_password">
                                </div>

                            </div>
                            <div class="row">
                                <div class="six columns">
                                    <label for="password">Current Password</label>
                                    <input  class="u-full-width" name="password" type="password" placeholder="**********" id="password">
                                </div>

                            </div>
                            <input type="hidden" name="id" value="<?php echo $user->data()->id; ?>"/>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>

                            <input class="button-primary" name="post" type="submit"  value="Change"> <a class="button" href="profile.php">Go Back</a>
                        </form>

                        <div style="margin-top:25%"> </div>
<?php } ?>



                </div>
            </div>
            <p style="position: fixed; margin-bottom:1%;"><?php echo Config::get('site/copy'); ?></p>
        </div>

        <!-- End Document
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    </body>
</html>
