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
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">User Account Update</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>User Account Update</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-info span6">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <form class="form-horizontal" method="post" action="<?php echo current_url(); ?>">
                                <fieldset>
                                    <legend>Personal Details</legend>
                                    <?php ?>
                                    <div class="control-group<?php $error = form_error('update_name'); echo!empty($error) ? ' error' : ''; ?>">
                                        <label class="control-label" for="inputName">Name:*</label>
                                        <div class="controls">
                                            <input type="text" name="update_name" id="inputName" placeholder="Nama" value="<?php echo set_value('update_name',$user['upro_name']);?>">
                                            <?php echo $error; ?>
                                        </div>
                                    </div>
                                    <div class="control-group<?php $error = form_error('update_phone_number'); echo!empty($error) ? ' error' : ''; ?>">
                                        <label class="control-label" for="inputPhone">Nomor Telepon:*</label>
                                        <div class="controls">
                                            <input type="text" name="update_phone_number" id="inputPhone" placeholder="Nomor Telepon" value="<?php echo set_value('update_phone_number',$user['upro_phone']); ?>">
                                            <?php echo $error; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputInduk">Nomor Induk:</label>
                                        <div class="controls">
                                            <input type="text" name="update_nomor_induk" id="inputInduk" placeholder="Nomor Induk" value="<?php echo set_value('update_first_name',$user['upro_nomor_induk']); ?>">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Login Details</legend>
                                    <div class="control-group<?php $error = form_error('update_email_address');
                                        echo!empty($error) ? ' error' : ''; ?>">
                                        <label class="control-label" for="inputEmail">Email:*</label>
                                        <div class="controls">
                                            <input type="text" name="update_email_address" id="inputEmail" placeholder="Email" value="<?php echo set_value('update_email_address',$user[$this->flexi_auth->db_column('user_acc', 'email')]); ?>">
                                            <?php echo $error; ?>
                                        </div>
                                    </div>
                                    <div class="control-group<?php $error = form_error('update_username');
                                        echo!empty($error) ? ' error' : ''; ?>">
                                        <label class="control-label" for="inputUserName">Username:*</label>
                                        <div class="controls">
                                            <input type="text" name="update_username" id="inputUserName" placeholder="Username" value="<?php echo set_value('update_username',$user[$this->flexi_auth->db_column('user_acc', 'username')]); ?>">
                                            <?php echo $error; ?>
                                        </div>
                                    </div>
                                    <div class="control-group<?php $error = form_error('update_group');
                                        echo!empty($error) ? ' error' : ''; ?>">
                                        <label class="control-label" for="group">Group:*</label>
                                        <div class="controls">
                                            <select id="group" name="update_group"
						title="Set the users group, that can define them as an admin, public, moderator etc.">
                                                <?php foreach($groups as $group) { ?>
                                                    <?php $user_group = ($group[$this->flexi_auth->db_column('user_group', 'id')] == $user[$this->flexi_auth->db_column('user_acc', 'group_id')]) ? TRUE : FALSE; ?>
                                                    <option value="<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')]; ?>" <?php echo set_select('update_group', $group[$this->flexi_auth->db_column('user_group', 'id')], $user_group); ?>>
                                                        <?php echo $group[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <?php echo $error; ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Privileges:</label>
                                        <div class="controls">
                                            <a href="<?php echo base_url('admin/update_user_privileges/'.$user[$this->flexi_auth->db_column('user_acc', 'id')]);?>"
                                            title="Manage a users access privileges.">Manage User Privileges</a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="submit" name="update_users_account" class="btn" value="Update Account">
                                        </div>
                                    </div>
                                </fieldset>
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
