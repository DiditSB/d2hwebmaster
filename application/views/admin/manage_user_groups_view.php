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
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Manage User Groups</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Manage User Groups</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <a class="btn btn-success" href="<?php echo base_url('admin/insert_user_group'); ?>" style="margin-bottom: 3px"><i class="icon-plus-sign"></i> Insert New User Group</a>
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th title="The user group name." class="span2" style="vertical-align: middle">
                                                Group Name
                                            </th>
                                            <th title="A short description of the purpose of the user group." class="span4" style="vertical-align: middle">
                                                Description
                                            </th>
                                            <th title="Indicates whether the group is considered an 'Admin' group. Note: Privileges can still be set seperately." style="text-align: center">
                                                Is Admin Group
                                            </th>
                                            <th title="Manage the access privileges of user groups." style="text-align: center">
                                                User Group Privileges
                                            </th>
                                            <th title="If checked, the row will be deleted upon the form being updated." class="span2" style="text-align: center; vertical-align: middle">
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_groups as $group) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url('admin/update_user_group/' . $group[$this->flexi_auth->db_column('user_group', 'id')]); ?>">
                                                        <?php echo $group[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $group[$this->flexi_auth->db_column('user_group', 'description')]; ?></td>
                                                <td class="align_ctr" style="text-align: center"><?php echo ($group[$this->flexi_auth->db_column('user_group', 'admin')] == 1) ? "Yes" : "No"; ?></td>
                                                <td class="align_ctr" style="text-align: center">
                                                    <a href="<?php echo base_url('admin/update_group_privileges/' . $group[$this->flexi_auth->db_column('user_group', 'id')]); ?>">Manage</a>
                                                </td>
                                                <td class="align_ctr" style="text-align: center">
                                                    <?php if ($this->flexi_auth->is_privileged('Delete User Groups')) { ?>
                                                        <input type="checkbox" name="delete_group[<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')]; ?>]" value="1"/>
                                                    <?php } else { ?>
                                                        <input type="checkbox" disabled="disabled"/>
                                                        <small>Not Privileged</small>
                                                        <input type="hidden" name="delete_group[<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')]; ?>]" value="0"/>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <td colspan="5">
                                        <?php $disable = (!$this->flexi_auth->is_privileged('Update User Groups') && !$this->flexi_auth->is_privileged('Delete User Groups')) ? 'disabled="disabled"' : NULL; ?>
                                        <input type="submit" name="submit" value="Delete Checked User Groups" class="btn" <?php echo $disable; ?>/>
                                    </td>
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
        <script>
            $(function() {
                setInterval(function() {$("div.alert").slideUp(1000);}, 3000);
            });
        </script>
    </body>
</html>
