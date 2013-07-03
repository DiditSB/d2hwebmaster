<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Resend activation | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <style type="text/css">
            body {
                padding-top: 40px;
            }
            #frame {
                width: 700px;
                margin: auto;
                margin-top: 125px;
                border: solid 1px #CCC;
                /* SOME CSS3 DIV SHADOW */
                -webkit-box-shadow: 0px 0px 10px #CCC;
                -moz-box-shadow: 0px 0px 10px #CCC;
                box-shadow: 0px 0px 10px #CCC;
                /* CSS3 ROUNDED CORNERS */
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                -khtml-border-radius: 5px;
                border-radius: 5px;
                background-color: #FFF;
            }
            #emailInput {
                height: 30px;
                line-height: 30px;
                padding: 3px;
                width: 300px;
            }
            .submitBtn {
                height: 40px;
                line-height: 40px;
                width: 120px;
                text-align: center;
                vertical-align: middle;
            }
            #frame h2 {
                text-align: center;
            }
            #frame form {
                text-align: center;
                margin-bottom: 30px;
            }
            #frame p {
                padding-left: 25px;
                padding-right: 25px;
            }
        </style>
    </head>
    
    <body>
        <div class="container" id="frame">
            <?php echo form_open(current_url(), 'class="form-inline"');?>
                
                <h2 class="form-signin-heading">Resend Activation</h2>
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
                <input type="text" id="emailInput" name="activation_token_identity" class="input-small" placeholder="Email">
                <input type="submit" class="btn submitBtn" name="send_activation_token" value="Submit">
                <a href="<?php echo site_url(); ?>" class="btn btn-success submitBtn">Cancel</a>
            <?php echo form_close();?>

        </div> <!-- /container -->
        
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
