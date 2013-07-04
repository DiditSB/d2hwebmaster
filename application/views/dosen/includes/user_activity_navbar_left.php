                <div class="span3">
                    <ul class="side-nav nav nav-list">
                        <li class="nav-header">
                            <i class="icon-map-marker"></i> User Activity
                        </li>

                        <li>
                            <a href="<?php echo site_url('admin/list_user_status/active'); ?>">
                                <i class="icon-th"></i> List all active users
                            </a>
                            <ul class="nav nav-list nav-namespaces"></ul>
                        <li>

                        <li>
                            <a href="<?php echo site_url('admin/list_user_status/inactive'); ?>">
                                <i class="icon-th"></i> List all inactive users
                            </a>
                            <ul class="nav nav-list nav-namespaces"></ul>
                        <li>
                        
                        <li>
                            <a href="<?php echo site_url('admin/delete_unactivated_users'); ?>">
                                <i class="icon-th"></i> Not Activated in 31 Days
                            </a>
                            <ul class="nav nav-list nav-namespaces"></ul>
                        <li>

                        <li>
                            <a href="<?php echo site_url('admin/failed_login_users'); ?>">
                                <i class="icon-th"></i> List all failed login users
                            </a>
                            <ul class="nav nav-list nav-namespaces"></ul>
                        <li>
                    </ul>
                </div>
