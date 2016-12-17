<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @Page: register.php
 *  @Description: Registering form for public user. 
 */
require_once 'core/init.php';
$user = new User();
if($user->isLoggedIn()){
    Redirect::to("profile.php");
}
if (Input::exists()) {
    if(Token::check(Input::get("token"))){
    $validate = new Validate();
    $validate = $validate->check($_POST, array(
        'username' => array(
            'required' => true,
            'min' => 2,
            'max' => 20,
            'nospace' =>true,
            'alphanumeric' =>true,
            'unique' => 'user'
        ),
        'full_name' => array(
            'required' => true,
            'min' => 2,
            'max' => 20,
            'realname' => TRUE
        ),
        'password' => array(
            'required' => true,
            'min' => 6,
        ),
        'confirm_password' => array(
            'required' => true,
            
            'matches' => 'password'
        ),
        'email' => array(
            'required' => true,
            'unique' =>'user',
            'max' => 30
        ),
        'contact' => array(
            'required' => true,
            'min'=>7,
            'max'=>14,
            'unique' => 'user',
            'phone'=> true
        ),
       
        
    ));
if ($validate->passed()) {
        // reigster user
    
    $salt = Hash::salt(32);
   
    try {
        $user->create(array(
            'full_name' =>  Input::get('full_name'),
            'contact' => Input::get('contact'),
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password'),$salt),
            'salt' =>  $salt,
            'joined' => date('Y-m-d H:i:s')
            
        ));
        $success= "Successfully Registered!";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    
    } else {
        // output errors
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
        if(isset($errors)){
            foreach ($errors as $error){ ?>
                <script type='text/javascript'>$.notify('<?php echo $error; ?>', 'warning');</script>
          <?php   }
        }
        ?>
                <?php
        if(isset($success)){
           ?>
                <script type='text/javascript'>$.notify('<?php echo $success; ?>', 'success');
                setTimeout(function () {
                    window.location.href = 'index.php';
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
                    <img alt="Login" src="images/login.png" style=" margin-left: -15%;float: left;"/>
                </div>


                <div class="one-half column" style="margin-top: 5%">
                    <h4>Guest Registration</h4>
                    <form name="post" action="register.php" method="post">
                        <div class="row">
                            <div class="six columns">
                                <label for="fullname">Full Name</label>
                                <input value="<?php echo escape(Input::get("full_name")); ?>" class="u-full-width" type="text" name="full_name" placeholder="Eg: Ronash Dhakal" id="fullname">
                            </div>
                            <div class="six columns">
                                <label for="contact">Contact</label>
                                <input value="<?php echo escape(Input::get("contact")); ?>" class="u-full-width" type="text" name="contact" placeholder="Eg: 9841131037" id="contact">
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="username">Username</label>
                                <input value="<?php echo escape(Input::get("username")); ?>" class="u-full-width" type="text" name="username" placeholder="username or e-mail" id="username">
                            </div>
                            <div class="six columns">
                                <label for="email">E-mail</label>
                                <input value="<?php echo escape(Input::get("email")); ?>" class="u-full-width" type="email" name="email" placeholder="example@ronash.com.np" id="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="six columns">
                                <label for="password">Password</label>
                                <input  class="u-full-width" name="password" type="password" placeholder="**********" id="password">
                            </div>
                            <div class="six columns">
                                <label for="repassword">confirm Password</label>
                                <input class="u-full-width" type="password" name="confirm_password" placeholder="**********" id="repassword">
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
                        <label class="example-send-yourself-copy">
                            <input type="checkbox" required="required" value="true" name="tac" checked="checked">
                            <span class="label-body">Accept Our <a href="termsAndconditions.php" target="_blank" >Terms and Conditions</a></span>
                          
                           
                        </label>
                        <input class="button-primary" name="post" type="submit"  value="Register">   <a class="button " onclick="alert('Registration Requirement!\n\
Full name should be min of 2 character. \n\
Full name must contain your family name and alphabets\n\
Contact must be valid phone number\n\
Username must be alphabets or alphnumeric with min 2 character\n\
E-mail must be valid email address\n\
Password must contain min of 6 length and should match confirm password ')" href="#">Help!</a>
                    </form>

                    <p>Already have an account? Sign In <a href='index.php'>Here</a></p>

                </div>
            </div>
            <p style="position: absolute;"><?php echo Config::get('site/copy'); ?></p>
        </div>

        <!-- End Document
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      
    </body>
</html>
