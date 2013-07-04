<!--<html>
    <head>
        <title>Insert Problem | d2hwebmaster</title>
    </head>
    <body>
        <?php if(!empty($message)) { echo $message; } ?>

        <?php echo form_open_multipart('dosen/insert_problem'); ?>

        <input type="file" name="insert_file_problem" size="20" />
        <?php if(!empty($upload_error)) { echo $upload_error; } ?>
        <br /><br />

        <input type="submit" name="add_problem" value="Add Problem" />

    </form>
</body>
</html>-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2))); ?> | d2hwebmaster</title>
        <?php $this->load->view('includes/head'); ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/datetimepicker.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css')?>">
    </head>

    <body>
        <?php $this->load->view('dosen/includes/navbar-top'); ?>
        <div class="container">
            <?php $this->load->view('dosen/includes/header_title'); ?>
            <div class="row">
                <?php $this->load->view('dosen/includes/global_users_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('dosen/dashboard'); ?>"><i class="icon-th"></i> Home</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo site_url('admin/manage_user_groups'); ?>">Manage User Groups</a>
                        </li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Insert User Group</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Insert Privilege</h3>
                        <div class="element" style="background-color: white">
                            <?php echo form_open_multipart('dosen/insert_problem', array('class' => 'form-horizontal')); ?>
                            <fieldset id="problem1">
                                <div class="control-group<?php $error = form_error('insert_problem_title');
                                    echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_problem_title">Title*</label>
                                    <div class="controls">
                                        <input type="text" id="insert_problem_title" name="insert_problem_title" value="<?php echo set_value('insert_problem_title'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_type">Type</label>
                                    <div class="controls">
                                        <select id="insert_problem_type" name="insert_problem_type" class="input-medium">
                                            <option value="tugas_mingguan">Tugas Mingguan</option>
                                            <option value="quiz">Quiz</option>
                                            <option value="uts">UTS</option>
                                            <option value="uas">UAS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_difficulty">Difficulty</label>
                                    <div class="controls">
                                        <select id="insert_problem_difficulty" name="insert_problem_difficulty" class="input-small">
                                            <option value="easy">Easy</option>
                                            <option value="medium">Medium</option>
                                            <option value="difficult">Difficult</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_file">Problem</label>
                                    <div class="controls">
                                        <input type="file" id="insert_problem_file" name="insert_problem_file">
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_date_start');
                                    echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_problem_date_start">Date Start</label>
                                    <div class="controls date form_datetime">
                                        <input type="text" readonly class="input-medium" id="insert_problem_date_start" name="insert_problem_date_start" value="<?php echo set_value('insert_problem_date_start'); ?>" />
                                        <span class="add-on btn"><i class="icon-calendar"></i></span>
                                        <span class="btn" id="date_start"><i class="icon-remove"></i></span>
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_date_end');
                                    echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_problem_date_end">Date End</label>
                                    <div class="controls date form_datetime">
                                        <input type="text" readonly class="input-medium" id="insert_problem_date_end" name="insert_problem_date_end" value="<?php echo set_value('insert_problem_date_end'); ?>" />
                                        <span class="add-on btn"><i class="icon-calendar"></i></span>
                                        <span class="btn" id="date_end"><i class="icon-remove"></i></span>
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_type_upload">Type Program</label>
                                    <div class="controls">
                                        <select id="insert_problem_type_upload" name="insert_problem_type_upload" class="input-small">
                                            <option value="1">1 file</option>
                                            <option value="3">3 file</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group" id="ganti">
                                    <label class="control-label" for="insert_problem_file">Program</label>
                                    <?php if(empty ($type_upload) || $type_upload == 1) { ?>
                                    <div class="controls">
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[0]">
                                    </div>
                                    <?php } else if($type_upload == 3) { ?>
                                    <div class="controls">
                                        <label>Header </label>
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[0]">
                                    </div>
                                    <div class="controls">
                                        <label>Main </label>
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[1]">
                                    </div>
                                    <div class="controls">
                                        <label>Function </label>
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[2]">
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_time_limit');
                                    echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_problem_time_limit">Time Limit</label>
                                    <div class="controls">
                                        <input type="text" class="input-small" id="insert_problem_time_limit" name="insert_problem_time_limit" value="<?php echo set_value('insert_problem_time_limit'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_memory_limit');
                                    echo!empty($error) ? ' error' : ''; ?>">
                                    <label class="control-label" for="insert_problem_memory_limit">Memory Limit</label>
                                    <div class="controls">
                                        <input type="text" class="input-small" id="insert_problem_memory_limit" name="insert_problem_memory_limit" value="<?php echo set_value('insert_problem_time_limit'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset style="display: none">
                                <legend>Testcase</legend>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_memory_limit">Input</label>
                                    <div class="controls">
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[0]">
                                    </div>
                                    <label class="control-label" for="insert_problem_memory_limit">Output</label>
                                    <div class="controls">
                                        <input type="file" id="insert_problem_file" name="insert_problem_file[0]">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="button" class="btn" id="next" value="Next" />
                                    <input type="submit" id="submit" style="display: none" name="insert_problem" class="btn" value="Submit" />
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
        <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
        <script>
        $(function() {
            var d = new Date();
            var startdate = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
            $(".form_datetime").datetimepicker({
                format: "yyyy-mm-dd hh:ii:ss",
                autoclose: true,
                todayBtn: true,
                startDate: startdate,
                minuteStep: 10,
                pickerPosition: "bottom-left"
            });
            
            $("#date_start").click(function() {
                $("#insert_problem_date_start").val("0000-00-00 00:00:00");
            });
            
            $("#date_end").click(function() {
                $("#insert_problem_date_end").val("0000-00-00 00:00:00");
            });
                
            $("#next").click(function() {
                var el = $(this);
                if(el.val() === "Next"){
                    el.val("Prev");
                } else {
                    el.val("Next");
                }
                $("fieldset, #submit").toggle();
            });
            
            $('#insert_problem_type_upload').change(function(){
                var value = $("#insert_problem_type_upload").val();
                if(value === "1") {
                    $("#ganti").empty().html(
                        '<label class="control-label" for="insert_problem_file">Program</label>'+
                        '<div class="controls">'+
                            '<input type="file" id="insert_problem_file" name="insert_problem_file[0]">'+
                        '</div>'
                    );
                } else {
                    $("#ganti").empty().html(
                        '<label class="control-label" for="insert_problem_file">Program</label>'+
                        '<div class="controls">'+
                            '<label>Header </label>'+
                            '<input type="file" id="insert_problem_file" name="insert_problem_file[0]">'+
                        '</div>'+
                        '<div class="controls">'+
                            '<label>Main </label>'+
                            '<input type="file" id="insert_problem_file" name="insert_problem_file[1]">'+
                        '</div>'+
                        '<div class="controls">'+
                            '<label>Function </label>'+
                            '<input type="file" id="insert_problem_file" name="insert_problem_file[2]">'+
                        '</div>'
                    );
                }
            });
            
//            $("#insert_problem_type_upload").on("change", "div.#ganti", function() {
//                if($("#insert_problem_type_upload").val() === "1") {
//                    $(this).empty().html(
//                        '<label class="control-label" for="insert_problem_file">Program</label>'+
//                        '<div class="controls">'+
//                            '<input type="file" id="insert_problem_file" name="insert_problem_file[0]">'+
//                        '</div>'
//                    );
//                } else {
//                    $(this).empty().html(
//                        '<label class="control-label" for="insert_problem_file">Program</label>'+
//                        '<div class="controls">'+
//                            '<label>Header </label>'+
//                            '<input type="file" id="insert_problem_file" name="insert_problem_file[0]">'+
//                        '</div>'+
//                        '<div class="controls">'+
//                            '<label>Main </label>'+
//                            '<input type="file" id="insert_problem_file" name="insert_problem_file[1]">'+
//                        '</div>'+
//                        '<div class="controls">'+
//                            '<label>Function </label>'+
//                            '<input type="file" id="insert_problem_file" name="insert_problem_file[2]">'+
//                        '</div>'
//                    );
//                }
//            });
        });
        </script>
    </body>
</html>

