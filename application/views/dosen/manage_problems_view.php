<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?> | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css') ?>">
    </head>

    <body>
        <?php $this->load->view('dosen/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('dosen/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('dosen/includes/user_activity_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('dosen/dashboard'); ?>"><i class="icon-th"></i> Home</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">List all <?php echo $page_title; ?></a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>List all <?php echo $page_title; ?></h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <a class="btn btn-success" href="<?php echo base_url('dosen/insert_problem'); ?>" style="margin-bottom: 3px"><i class="icon-plus-sign"></i> Insert New Problems</a>
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>File Name</th>
                                            <th style="text-align: center"
                                                title="Indicates the user group the user belongs to.">
                                                Date Added
                                            </th>
                                            <th style="text-align: center" 
                                                title="Indicates whether the users account is currently set as 'active'.">
                                                <?php echo $page_title == 'Active Problems' ? 'Deactive' : 'Activate' ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($problems)) { ?>
                                        <tbody>
                                            <?php foreach ($problems as $problem) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo base_url('dosen/update_problems/'.$problem['problem_title'].'/'.$problem['problem_id']); ?>">
                                                            <?php echo $problem['problem_title']; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $problem['problem_orig_name']; ?>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <?php echo $problem['problem_date_added']; ?>
                                                    </td>
                                                    <td style="text-align: center" id="status<?php echo $problem['problem_id']; ?>">
                                                        <?php if($status === 'inactive_problems') { ?>
                                                        <a href="<?php echo base_url('dosen/activate_problems/'.$problem['problem_title'].'/'.$problem['problem_id']); ?>" class="btn btn-info">
                                                            activate
                                                        </a>
                                                        <?php } else { ?>
                                                        <a href="<?php echo base_url('dosen/deactivate_problems/'.$problem['problem_title'].'/'.$problem['problem_id']); ?>" class="btn btn-danger">
                                                            Deactive
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    <?php } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="alert alert-info" style="text-align: center">
                                                    No users are available.
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php $this->load->view('includes/footer'); ?>

        <!-- Scripts -->
        <?php $this->load->view('includes/scripts'); ?>
        <script>
            $(function() {
                setInterval(function() {
                    $("div.alert").slideUp(1000);
                }, 3000);
            });
        </script>
    </body>
</html>
