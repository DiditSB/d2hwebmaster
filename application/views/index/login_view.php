<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <style type="text/css">
            body {
                padding-top: 40px;
            }
            .form-signin {
                max-width: 450px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0px 0px 10px #CCC;
                -moz-box-shadow: 0px 0px 10px #CCC;
                box-shadow: 0px 0px 10px #CCC;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }
            .alert-info {
                text-align: center;
            }
            #message .error_msg {
                padding: 5px;
            }
            footer {
                margin-top: auto;
                background-color: #f5f5f5;
            }

            /* Lastly, apply responsive CSS fixes as necessary */
            @media (max-width: 767px) {
                footer {
                    margin-left: -20px;
                    margin-right: -20px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
            }
            
/*            .container {
                width: auto;
                max-width: 680px;
            }*/
            .container .credit {
                margin: 20px 0;
            }
        </style>
    </head>
    
    <body>
        <div class="container">
            <?php echo form_open(current_url(), 'class="form-signin"');?>
                
                <h2 class="form-signin-heading">Please sign in</h2>
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
                <input type="text" class="input-block-level" name="login_identity" placeholder="Email address or Username" value="<?php echo set_value('login_identity');?>">
                <input type="password" class="input-block-level" name="login_password" placeholder="Password" value="<?php echo set_value('login_password');?>">
                <?php if (isset($captcha)) { echo $captcha; } ?>
                <input class="btn btn-large btn-primary" type="submit" name="login_user" value="Sign in">
                <label class="checkbox inline">
                    <input type="checkbox" name="remember_me" value="1" <?php echo set_checkbox('remember_me', 1); ?>> Remember me
                </label>
                <hr />
                <p>
                    <a href="<?php echo site_url('index/register_account'); ?>">Register</a><br />
                    <a href="<?php echo site_url('index/forgotten_password'); ?>">Forgot your password?</a><br />
                    <a href="<?php echo site_url('index/resend_activation_token'); ?>">Resend Activation</a><br />
                </p>
            <?php echo form_close();?>

        </div> <!-- /container -->
        
        <!-- Footer -->
	<?php $this->load->view('includes/footer'); ?>
        
        <!-- Scripts -->  
        <?php $this->load->view('includes/scripts'); ?>
        <script>
        $(function() {
            document.forms[0].elements[0].focus();
            setTimeout(function() {
                $("div.alert").slideUp(1000);
            }, 3000);
        });
        </script>
    </body>
</html>
