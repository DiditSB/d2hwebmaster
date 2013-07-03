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
                            <span class="divider">\</span><a href="<?php echo site_url('admin/manage_privileges'); ?>">Manage User Privileges</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Manage Privilege</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <a class="btn btn-success" href="<?php echo base_url('admin/insert_privilege'); ?>" style="margin-bottom: 3px"><i class="icon-plus-sign"></i> Insert New Privilege</a>
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th title="The name of the privilege."/>
                                            Privilege Name
                                            </th>
                                            <th title="A short description of the purpose of the privilege."/>
                                            Description
                                            </th>
                                            <th style="text-align: center"
                                                title="If checked, the row will be deleted upon the form being updated."/>
                                            Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($privileges as $privilege) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url('admin/update_privilege/'.$privilege[$this->flexi_auth->db_column('user_privileges', 'id')]); ?>">
                                                        <?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'name')]; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'description')]; ?></td>
                                                <td style="text-align: center">
                                                    <?php if ($this->flexi_auth->is_privileged('Delete Users')) { ?>
                                                        <input type="checkbox" name="delete_privilege[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>]" value="1"/>
                                                    <?php } else { ?>
                                                        <input type="checkbox" disabled="disabled"/>
                                                        <small>Not Privileged</small>
                                                        <input type="hidden" name="delete_privilege[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>]" value="0"/>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <?php $disable = (! $this->flexi_auth->is_privileged('Update Privileges') && !$this->flexi_auth->is_privileged('Delete Privileges')) ? 'disabled="disabled"' : NULL; ?>
                                                <input type="submit" name="submit" value="Delete Checked Privileges" class="btn" <?php echo $disable; ?>/>
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
        <script>
            $(function() {
                setInterval(function() {$("div.alert").slideUp(1000);}, 3000);
            });
        </script>
    </body>
</html>
