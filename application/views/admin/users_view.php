<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?> | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css') ?>">
    </head>

    <body>
        <?php $this->load->view('admin/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('admin/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('admin/includes/user_activity_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/index'); ?>"><i class="icon-th"></i> Home</a></li>
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
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                            <th style="text-align: center"
                                                title="Indicates the user group the user belongs to.">
                                                User Group
                                            </th>
                                            <?php if (isset($status) && $status == 'failed_login_users') { ?>
                                                <th style="text-align: center"
                                                    title="The number of consecutive failed login attempts made since the user last successfully logged in.">
                                                    Failed Attempts</th>
                                            <?php } ?>
<!--                                            <th style="text-align: center" 
                                                title="Indicates whether the users account is currently set as 'active'.">
                                                Status
                                            </th>-->
                                            <th style="text-align: center" 
                                                title="Indicates whether the users account is currently set as 'active'.">
                                                <?php echo $page_title == 'Active Users' ? 'Deactive' : 'Activate' ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($users)) { ?>
                                        <tbody>
                                            <?php foreach ($users as $user) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo base_url('admin/update_user_account/'.$user[$this->flexi_auth->db_column('user_acc', 'id')]); ?>">
                                                            <?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')]; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $user['upro_name']; ?>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <?php echo $user[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                                    </td>
                                                    <?php if (isset($status) && $status == 'failed_login_users') { ?>
                                                        <td style="text-align: center">
                                                            <?php echo $user[$this->flexi_auth->db_column('user_acc', 'failed_logins')]; ?>
                                                        </td>
                                                    <?php } ?>
<!--                                                    <td style="text-align: center">
                                                        <?php echo ($user[$this->flexi_auth->db_column('user_acc', 'active')] == 1) ? 'Active' : 'Inactive';?>
                                                    </td>-->
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="update[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="1" />
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                        <?php if(isset($status) && $status != 'failed_login_users') { ?>
                                        <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                        <input type="submit" name="update_list_user_status" value="Update List Users Status" class="btn"/>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                    <?php } } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="<?php echo isset($status) && $status == 'failed_login_users' ? '5' : '4'; ?>" class="alert alert-info" style="text-align: center">
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
