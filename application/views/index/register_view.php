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
            
                <h2 class="form-signin-heading">Register Account</h2>
            <div class="control-group">
                <label class="control-label" for="inputUser">User type:*</label>
                <div class="controls">
                    <select id="inputUser" name="register_group">
                        <option value="1"<?php echo set_select('register_group', '1', TRUE); ?>>Mahasiswa</option>
                        <option value="2"<?php echo set_select('register_group', '2'); ?>>Dosen</option>
                        <option value="3"<?php echo set_select('register_group', '3'); ?>>Guest</option>
                    </select>
                </div>
            </div>
            <fieldset>
		<legend>Personal Details</legend>
                <?php  ?>
                <div class="control-group<?php $error = form_error('register_name'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputName">Nama:*</label>
                    <div class="controls">
                        <input type="text" name="register_name" id="inputName" placeholder="Nama" value="<?php echo set_value('register_name');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('register_phone_number'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputPhone">Nomor Telepon:*</label>
                    <div class="controls">
                        <input type="text" name="register_phone_number" id="inputPhone" placeholder="Nomor Telepon" value="<?php echo set_value('register_phone_number');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('register_nomor_induk'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputInduk">Nomor Induk:</label>
                    <div class="controls">
                        <input type="text" name="register_nomor_induk" id="inputInduk" placeholder="Nomor Induk" value="<?php echo set_value('register_nomor_induk');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
            </fieldset>
            <fieldset>
		<legend>Login Details</legend>
                <div class="control-group<?php $error = form_error('register_email_address'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputEmail">Email:*</label>
                    <div class="controls">
                        <input type="text" name="register_email_address" id="inputEmail" placeholder="Email" value="<?php echo set_value('register_email_address');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('register_username'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputUserName">Username:*</label>
                    <div class="controls">
                        <input type="text" name="register_username" id="inputUserName" placeholder="Username" value="<?php echo set_value('register_username');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('register_password'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputPassword">Password:*</label>
                    <div class="controls">
                        <input type="password" name="register_password" id="inputPassword" placeholder="Password" value="<?php echo set_value('register_password');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group<?php $error = form_error('register_confirm_password'); echo !empty($error) ? ' error': ''; ?>">
                    <label class="control-label" for="inputConfirmPassword">Confirm Password:*</label>
                    <div class="controls">
                        <input type="password" name="register_confirm_password" id="inputConfirmPassword" placeholder="Confirm Password" value="<?php echo set_value('register_confirm_password');?>">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" name="register_user" id="inputRegister" class="btn" value="Register">
                        <a href="<?php echo site_url(); ?>" class="btn btn-success">Cancel</a>
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
                $('#inputInduk').tooltip({
                        placement: 'right',
                        trigger: 'focus',
                        title: 'This required if you are Mahasiswa or Dosen'
                });
                $('#inputPhone').tooltip({
                        placement: 'right',
                        trigger: 'focus',
                        title: 'Example: 08123456789, 024123456'
                });
                $('#inputPassword').tooltip({
                        placement: 'right',
                        trigger: 'focus',
                        title: 'Password length must be more than 8 characters in length. Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.'
                });
            });
        </script>
    </body>
</html>
