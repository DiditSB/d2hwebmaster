<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2))); ?> | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css')?>">
    </head>

    <body>
        <?php $this->load->view('dosen/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('dosen/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('dosen/includes/user_activity_navbar_left'); ?>
                <div class="span9" id="result">
                    
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php $this->load->view('includes/footer'); ?>

        <!-- Scripts -->
        <?php 
            $this->load->view('includes/scripts');
        ?>
        <script>
            $(function() {
                setInterval(function() {$("div.alert").slideUp(1000);}, 3000);
                
                var url = location.href;
                if(url.search("problem") != -1) {
                    url = url.replace("detail", "get_detail_problem");
                }
                
                $("#result").load(url);
                var refreshId = setInterval(function() {
                   $("#result").load(url);
                }, 300000);
                $.ajaxSetup({ cache: false });
            });
        </script>
    </body>
</html>
