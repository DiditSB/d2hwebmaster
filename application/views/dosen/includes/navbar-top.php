        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand active" href="<?php echo site_url('dosen'); ?>">d2hwebmaster</a>
                    <div class="nav-collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-off icon-white"></i>Dropdown<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url('admin/update_user_account/'.$this->flexi_auth->get_user_id()); ?>"><strong><?php print_r($this->flexi_auth->get_user_identity()); ?></strong>
                                            <small class="metadata">Edit profile</small></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('index/logout'); ?>">Sign Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
