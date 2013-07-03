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
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Manage User Accounts</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Manage User Accounts</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <?php echo form_open(current_url(), array('class' => 'form-search')); ?>
                                    <input type="text" id="search" name="search_query" value="<?php echo set_value('search_query', $search_query); ?>"
                                           title="Searches for users by email and name." placeholder="Email or Name" class="search-query"
                                           />
                                    <input type="submit" name="search_users" value="Search" class="btn btn-success"/>
                                    <a href="<?php echo base_url('admin/manage_user_accounts'); ?>" class="btn btn-info">Reset</a>
                            <?php echo form_close(); ?>
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle">Email</th>
                                            <th style="vertical-align: middle">Name</th>
                                            <th style="vertical-align: middle">Date Added</th>
                                            <th title="Indicates the user group the user belongs to.">
                                                User Group
                                            </th>
                                            <th style="text-align: center" title="Manage the access privileges of users.">
                                                User Privileges
                                            </th>
                                            <th style="text-align: center" title="If checked, the users account will be locked and they will not be able to login.">
                                                Account Suspended
                                            </th>
                                            <th style="text-align: center; vertical-align: middle" title="If checked, the row will be deleted upon the form being updated.">
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($users)) { ?>
                                        <tbody>
                                            <?php foreach ($users as $user) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo base_url('admin/update_user_account/' . $user[$this->flexi_auth->db_column('user_acc', 'id')]); ?>">
                                                            <?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')]; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $user['upro_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $user[$this->flexi_auth->db_column('user_acc', 'date_added')]; ?>
                                                    </td>
                                                    <td class="align_ctr">
                                                        <?php echo $user[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="<?php echo base_url('admin/update_user_privileges/' . $user[$this->flexi_auth->db_column('user_acc', 'id')]); ?>">Manage</a>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="hidden" name="current_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'suspend')]; ?>"/>
                                                        <!-- A hidden 'suspend_status[]' input is included to detect unchecked checkboxes on submit -->
                                                        <input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="0"/>

                                                        <?php if ($this->flexi_auth->is_privileged('Update Users')) { ?>
                                                            <input type="checkbox" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="1" <?php echo ($user[$this->flexi_auth->db_column('user_acc', 'suspend')] == 1) ? 'checked="checked"' : ""; ?>/>
                                                        <?php } else { ?>
                                                            <input type="checkbox" disabled="disabled"/>
                                                            <small>Not Privileged</small>
                                                            <input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="0"/>
                                                        <?php } ?>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <?php if ($this->flexi_auth->is_privileged('Delete Users')) { ?>
                                                            <input type="checkbox" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="1"/>
                                                        <?php } else { ?>
                                                            <input type="checkbox" disabled="disabled"/>
                                                            <small>Not Privileged</small>
                                                            <input type="hidden" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="0"/>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php echo $pagination['links'];
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
    <?php $disable = (!$this->flexi_auth->is_privileged('Update Users') && !$this->flexi_auth->is_privileged('Delete Users')) ? 'disabled="disabled"' : NULL; ?>
                                                    <input type="submit" name="update_users" value="Update / Delete Users" class="btn" <?php echo $disable; ?>/>
                                                </td>
                                            </tr>
                                        </tfoot>
<?php } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="7" class="alert alert-info" style="text-align: center">
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
