<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <style type="text/css">
            body {
                padding-top: 40px;
            }
            .form-signin {
                max-width: 600px;
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
            .alert-info {
                text-align: center;
            }
            #message .error_msg {
                padding: 5px;
            }
            footer {
                background-color: #f5f5f5;
            }

            /* Lastly, apply responsive CSS fixes as necessary */
            @media (max-width: 767px) {
                #footer {
                    margin-left: -20px;
                    margin-right: -20px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
            }
            
            .container {
                width: auto;
                max-width: 680px;
            }
            .container .credit {
                margin: 20px 0;
            }
        </style>
    </head>
    
    <body>
        <div class="container">
            <?php echo form_open(current_url(), 'class="form-signin form-horizontal"'); ?>
            
                <h2 class="form-signin-heading">Change Forgotten Password</h2>
                <div class="control-group<?php $error = form_error('new_password'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="new_password">New Password:*</label>
                    <div class="controls">
                        <input type="password" name="new_password" id="new_password" placeholder="Password" value="<?php echo set_value('new_password');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('confirm_new_password'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputConfirmPassword">Confirm Password:*</label>
                    <div class="controls">
                        <input type="password" name="confirm_new_password" id="inputConfirmPassword" placeholder="Confirm Password" value="<?php echo set_value('confirm_new_password');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" name="change_forgotten_password" id="inputRegister" class="btn" value="Submit">
                    </div>
                </div>
            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <!-- Footer -->
	<?php $this->load->view('includes/footer'); ?>
        
        <!-- Scripts -->  
        <?php $this->load->view('includes/scripts'); ?>
        <script>
            $(function() {
                document.forms[0].elements[0].focus();
            setInterval(function() {
                $("div.alert").slideUp(1000);
            }, 3000);
            });
        </script>
    </body>
</html>
