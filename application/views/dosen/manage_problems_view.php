<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>List all problems | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css') ?>">
    </head>

    <body>
        <?php $this->load->view('dosen/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('dosen/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('dosen/includes/user_activity_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li>
                            <span class="divider"></span><a href="<?php echo current_url(); ?>"><i class="icon-th"></i> List all problems</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>List all problems</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <?php echo form_open(current_url(), array('class' => 'form-search')); ?>
                                    <input type="text" id="search" name="search_query" value="<?php echo set_value('search_query', $search_query); ?>"
                                           title="Searches for problem by title." placeholder="Title" class="search-query" autocomplete="off"
                                           />
                                    <input type="submit" name="search_problem" value="Search" class="btn btn-success"/>
                                    <a href="<?php echo base_url('dosen/list_problems'); ?>" class="btn btn-info">Reset</a>
                            <?php echo form_close(); ?>
                            <a class="btn btn-success" href="<?php echo base_url('dosen/insert_problem'); ?>" style="margin-bottom: 3px"><i class="icon-plus-sign"></i> Insert New Problems</a>
                            <form method="post" action="<?php echo current_url(); ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th style="text-align: center"
                                                title="Indicates the user group the user belongs to.">
                                                Date Added
                                            </th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($problems)) { ?>
                                        <tbody>
                                            <?php foreach ($problems as $problem) { ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo base_url('dosen/detail/problem/'.$problem['problem_id']); ?>">
                                                            <?php echo $problem['problem_title']; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if($problem['problem_active'] == 0) {
                                                                echo ' <span class="label label-warning">Not Published yet</span>';
                                                            } else if($problem['problem_active'] == 1) {
                                                                echo ' <span class="label label-success">Published</span>';
                                                            } else {
                                                                echo ' <span class="label">Not Published</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <?php echo $problem['problem_date_added']; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    <?php } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="alert alert-info" style="text-align: center">
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
                
                $('.search-query').typeahead({
                    source: function (query, process) {
                        return $.post('<?php echo site_url('dosen/problem_typeahead/'); ?>', { query: query }, function (data) {
                            return process(data);
                        });
                    }
                });
            });
        </script>
    </body>
</html>
