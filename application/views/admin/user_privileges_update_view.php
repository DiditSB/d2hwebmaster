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
                            <span class="divider">\</span><a href="<?php echo site_url('admin/manage_user_accounts'); ?>">Manage User Accounts</a>
                        </li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo site_url('admin/update_user_account/' . $user['upro_uacc_fk']); ?>">User Account Update</a>
                        </li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Manage User Privilege</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h4>Manage User Privilege of '<?php echo $user['upro_name']; ?>', Member of Group '<?php echo $user['ugrp_name']; ?>'</h4>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-info span6">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <form class="form-horizontal" method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th title="The name of the privilege." style="vertical-align: middle">
                                            Privilege Name
                                            </th>
                                            <th title="A short description of the purpose of the privilege." style="vertical-align: middle">
                                            Description
                                            </th>
                                            <th title="If checked, the user will be granted the privilege, regardless of whether their user group has the privilege." style="text-align: center">
                                            User Has Individual Privilege
                                            </th>
                                            <th title="Indicates whether the privilege has been assigned to the user via the privileges defined for their user group." style="text-align: center">
                                            Has Privilege From User Group
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($privileges as $privilege) { ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][id]" value="<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>"/>
                                                    <?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'name')]; ?>
                                                </td>
                                                <td><?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'description')]; ?></td>
                                                <td style="text-align: center">
                                                    <?php
                                                    // Define form input values.
                                                    $current_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 1 : 0;
                                                    $new_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 'checked="checked"' : NULL;
                                                    ?>
                                                    <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][current_status]" value="<?php echo $current_status ?>"/>
                                                    <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][new_status]" value="0"/>
                                                    <input type="checkbox" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][new_status]" value="1" <?php echo $new_status ?>/>
                                                </td>
                                                <td style="text-align: center">
                                                    <?php echo (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $group_privileges) ? 'Yes' : 'No'); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <input type="submit" name="update_user_privilege" value="Update User Privileges" class="btn"/>
                                            </td>
                                        </tr>
                                    </tfoot>
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
    </body>
</html>
