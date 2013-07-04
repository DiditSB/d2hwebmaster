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
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/index'); ?>"><i class="icon-th"></i> Home</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo site_url('admin/manage_privileges'); ?>">Manage User Privileges</a>
                        </li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Insert Privilege</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Insert Privilege</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-info span6">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <form class="form-horizontal" method="post" action="<?php echo current_url(); ?>">
                                <div class="control-group<?php $error = form_error('insert_privilege_name');
                        echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_privilege_name">Privilege*</label>
                                    <div class="controls">
                                        <input type="text" id="insert_privilege_name" name="insert_privilege_name" value="<?php echo set_value('register_name'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_privilege_description">Privilege Description</label>
                                    <div class="controls">
                                        <textarea id="insert_privilege_description" name="insert_privilege_description" class="span4"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" name="insert_privilege" class="btn" value="Submit" />
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
