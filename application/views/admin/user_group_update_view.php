<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2))); ?> | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css')?>">
    </head>

    <body>
        <?php $this->load->view('admin/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('admin/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('admin/includes/global_users_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/index'); ?>"><i class="icon-th"></i> Home</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo site_url('admin/manage_user_groups'); ?>">Manage User Groups</a>
                        </li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Update User Group</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Update User Group</h3>
                        <div class="element" style="background-color: white">
                            <form class="form-horizontal" method="post" action="<?php echo current_url(); ?>">
                                <div class="control-group<?php $error = form_error('update_group_name');
                        echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="update_group_name">Group Name*</label>
                                    <div class="controls">
                                        <input type="text" id="update_group_name" name="update_group_name" value="<?php echo set_value('update_group_name', $group[$this->flexi_auth->db_column('user_group', 'name')]);?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="update_group_description">User Group Description</label>
                                    <div class="controls">
                                        <textarea id="update_group_description" name="update_group_description" class="span4"><?php echo set_value('update_group_description', $group[$this->flexi_auth->db_column('user_group', 'description')]);?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="update_group_admin">Is Admin Group</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" id="update_group_admin" name="update_group_admin" value="1" <?php echo set_checkbox('update_group_admin', 1, $ugrp_admin);?>>
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="admin">User Group Privileges:</label>
                                    <div class="controls">
                                        <a href="<?php echo base_url('auth_admin/update_group_privileges/'.$group['ugrp_id']); ?>">Manage Privileges for this User Group</a>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" name="update_user_group" class="btn" value="Submit" />
                                    </div>
                                </div>
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
    </body>
</html>
