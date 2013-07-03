<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dashboard | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <style>
            body {
                background: #f9f9f9;
                color: #444;
            }
            a {
                color: #55A72F;
            }
            .hero-unit h1 {
                text-align: center;
                font-weight: normal;
                text-align: center;
                color: white;
                text-shadow: black 0px 0px 15px;
            }
            .hero-unit h2 {
                border: none;
                color: white;
                background: rgba(48, 48, 48, 0.5);
                padding: 0;
                margin: 0;
                margin-top: 15px;
                text-align: center;
            }
            .well {
                background-color: white;
            }
        </style>
    </head>

    <body>
        <?php $this->load->view('admin/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('admin/includes/header_title'); ?>
            <div class="row">
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-success" style="margin-left: 30px; text-align: center; vertical-align: middle">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
                <div class="span6">
                    <div class="well">
                        <ul class="nav nav-list">
                            <li class="nav-header">Global User</li>
                            <li><a href="<?php echo site_url('admin/manage_user_accounts'); ?>">Manage User Accounts</a></li>
                            <li><a href="<?php echo site_url('admin/manage_user_groups'); ?>">Manage User Groups</a></li>
                            <li><a href="<?php echo site_url('admin/manage_privileges'); ?>">Manage Previleges</a></li>
                        </ul>
                    </div>

                    <div class="well">
                        <ul class="nav nav-list">
                            <li class="nav-header">Dosen</li>
                            <li><a href="packages/default.html">Global ()</a></li>
                            <li><a href="packages/Not yet implemented.html">Not yet implemented</a></li>
                        </ul>
                    </div>

                </div>
                <div class="span6">
                    <div class="well">
                        <ul class="nav nav-list">
                            <li class="nav-header">User Activity</li>
                            <li>
                                <a href="<?php echo site_url('admin/list_user_status/active'); ?>">
                                    <i class="icon-list-alt"></i> List all active users
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/list_user_status/inactive') ?>">
                                    <i class="icon-list-alt"></i> List all inactive users
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/delete_unactivated_users') ?>">
                                    <i class="icon-list-alt"></i> List all unactivated (Never been activated) users over 31 days old
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/failed_login_users') ?>">
                                    <i class="icon-list-alt"></i> List users with a high number of failed login attempts
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="well">
                        <ul class="nav nav-list">
                            <li class="nav-header">Reports</li>
                            <li>
                                <a href="errors.html">
                                    <i class="icon-list-alt"></i> Errors                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <span class="label label-info">120</span>

                                </a>
                            </li>
                            <li>
                                <a href="markers.html">
                                    <i class="icon-list-alt"></i> Markers                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <span class="label label-info">20</span>

                                </a>
                            </li>
                        </ul>
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
