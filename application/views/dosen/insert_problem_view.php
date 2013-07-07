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
                <?php $this->load->view('dosen/includes/user_activity_navbar_left'); ?>
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('dosen/list_problems'); ?>"><i class="icon-th"></i> List all problems</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Insert Problem</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Insert New Problem</h3>
                        <div class="element" style="background-color: white">
                            <?php echo form_open_multipart('dosen/insert_problem', array('class' => 'form-horizontal'));
                            $form_error = array();
                            ?>
                            <div class="control-group<?php $error = form_error('insert_problem_title');
                                    if(!empty($error)) { echo ' error'; array_push($form_error, $error); } else { echo ''; } ?>">
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
                                            <option value="tugas_mingguan" <?php echo set_select('insert_problem_type', 'tugas_mingguan', TRUE); ?> >Tugas Mingguan</option>
                                            <option value="quiz" <?php echo set_select('insert_problem_type', 'quiz'); ?> >Quiz</option>
                                            <option value="uts" <?php echo set_select('insert_problem_type', 'uts'); ?> >UTS</option>
                                            <option value="uas" <?php echo set_select('insert_problem_type', 'uas'); ?> >UAS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_difficulty">Difficulty</label>
                                    <div class="controls">
                                        <select id="insert_problem_difficulty" name="insert_problem_difficulty" class="input-small">
                                            <option value="easy" <?php echo set_select('insert_problem_difficulty', 'easy', TRUE); ?> >Easy</option>
                                            <option value="medium" <?php echo set_select('insert_problem_difficulty', 'medium'); ?> >Medium</option>
                                            <option value="difficult" <?php echo set_select('insert_problem_difficulty', 'difficult'); ?> >Difficult</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_date_start'); 
                                if(!empty($error)) { echo ' error'; array_push($form_error, $error); } else { echo ''; } ?>">
                                    <label class="control-label" for="insert_problem_date_start">Date Start</label>
                                    <div class="controls date form_datetime">
                                        <input type="text" readonly class="input-medium" id="insert_problem_date_start" name="insert_problem_date_start" value="<?php echo set_value('insert_problem_date_start'); ?>" />
                                        <span class="add-on btn"><i class="icon-calendar"></i></span>
                                        <span class="btn" id="date_start"><i class="icon-remove"></i></span>
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_date_end');
                                    if(!empty($error)) { echo ' error'; array_push($form_error, $error); } else { echo ''; } ?>">
                                    <label class="control-label" for="insert_problem_date_end">Date End</label>
                                    <div class="controls date form_datetime">
                                        <input type="text" readonly class="input-medium" id="insert_problem_date_end" name="insert_problem_date_end" value="<?php echo set_value('insert_problem_date_end'); ?>" />
                                        <span class="add-on btn"><i class="icon-calendar"></i></span>
                                        <span class="btn" id="date_end"><i class="icon-remove"></i></span>
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_time_limit');
                                    if(!empty($error)) { echo ' error'; array_push($form_error, $error); } else { echo ''; } ?>">
                                    <label class="control-label" for="insert_problem_time_limit">Time Limit</label>
                                    <div class="controls">
                                        <input type="text" class="input-small" id="insert_problem_time_limit" name="insert_problem_time_limit" value="<?php echo set_value('insert_problem_time_limit'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                                <div class="control-group<?php $error = form_error('insert_problem_memory_limit');
                                    if(!empty($error)) { echo ' error'; array_push($form_error, $error); } else { echo ''; } ?>">
                                    <label class="control-label" for="insert_problem_memory_limit">Memory Limit</label>
                                    <div class="controls">
                                        <input type="text" class="input-small" id="insert_problem_memory_limit" name="insert_problem_memory_limit" value="<?php echo set_value('insert_problem_memory_limit'); ?>" />
                                        <?php echo $error; ?>
                                    </div>
                                </div><?php $jml_error = count($form_error); ?>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_file">Problem</label>
                                    <div class="controls">
                                        <input type="file" id="insert_problem_file" name="insert_problem_file">
                                        <?php 
                                        if($jml_error > 0) {
                                            echo 'error_upload_file';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="insert_problem_type_upload">Type Program</label>
                                    <div class="controls">
                                        <select id="insert_problem_type_upload" name="insert_problem_type_upload" class="input-small">
                                            <option value="1" <?php echo set_select('insert_problem_type_upload', '1', TRUE); ?> >1 file</option>
                                            <option value="3" <?php echo set_select('insert_problem_type_upload', '3'); ?> >3 file</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group" id="ganti">
                                    <label class="control-label">Program</label>
                                    <?php if(empty($type_upload) || $type_upload == 1) { ?>
                                    <div class="controls">
                                        <input type="file" name="insert_problem_program_0">
                                        <?php 
                                        if($jml_error > 0) {
                                            echo $error_upload_file;
                                        }
                                        if(!empty($upload_error_program_0)) {
                                            echo $upload_error_program_0;
                                        }
                                        ?>
                                    </div>
                                    <?php } else if($type_upload == 3) { ?>
                                    <div class="controls">
                                        <label>Header </label>
                                        <input type="file" name="insert_problem_program_0">
                                        <?php 
                                        if($jml_error > 0) {
                                            echo $error_upload_file;
                                        }
                                        if(!empty($upload_error_program_0)) {
                                            echo $upload_error_program_0;
                                        }
                                        ?>
                                    </div>
                                    <div class="controls">
                                        <label>Main </label>
                                        <input type="file" name="insert_problem_program_1">
                                        <?php 
                                        if($jml_error > 0) {
                                            echo $error_upload_file;
                                        }
                                        if(!empty($upload_error_program_1)) {
                                            echo $upload_error_program_1;
                                        }
                                        ?>
                                    </div>
                                    <div class="controls">
                                        <label>Function </label>
                                        <input type="file" name="insert_problem_program_2">
                                        <?php 
                                        if($jml_error > 0) {
                                            echo $error_upload_file;
                                        }
                                        if(!empty($upload_error_program_2)) {
                                            echo $upload_error_program_2;
                                        }
                                        ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            <fieldset id="testcase">
                                <legend>Testcase</legend>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="button" class="btn" id="insert_add_test" value="Add">
                                        <input type="button" class="btn" id="insert_remove_test" value="Remove">
                                        <input type="hidden" id="insert_jml_test" name="insert_jml_test" value="<?php $jml_test = set_value('insert_jml_test', '0'); echo $jml_test; ?>" />
                                    </div>
                                </div>
                                <?php 
                                if($jml_error > 0) {
                                    $tampil_error = $error_upload_file;
                                } else {
                                    $tampil_error = '';
                                }
                                
                                for($i = 0; $i <= $jml_test; $i++) {
                                echo '
                                <div class="control-group" id="t"'.$i.'>
                                    <label class="control-label">T'.$i.' Input</label>
                                    <div class="controls">
                                        <input type="file" name="insert_problem_testcase_in_'.$i.'">'.
                                        $tampil_error
                                    .'</div>
                                    <label class="control-label">T'.$i.' Output</label>
                                    <div class="controls">
                                        <input type="file" name="insert_problem_testcase_out_'.$i.'">'.
                                        $tampil_error
                                    .'
                                    </div>
                                </div>';
                                $error_in = 'upload_error_testcase_in_'.$i;
                                $error_out = 'upload_error_testcase_out_'.$i;
                                if(!empty($$error_in)) {
                                    echo $$error_in;
                                }
                                if(!empty($$error_out)) {
                                    echo $$error_out;
                                }
                                } ?>
                            </fieldset>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" id="submit" name="insert_problem" class="btn" value="Submit" />
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
            
            $("#insert_add_test").click(function() {
                var test = $("#insert_jml_test");
                var jml_test = parseInt(test.val())+1;
                test.val(jml_test);
                $("#testcase").append('<div class="control-group" id="t'+jml_test+'">'+
                                    '<label class="control-label">T'+jml_test+' Input</label>'+
                                    '<div class="controls">'+
                                        '<input type="file" name="insert_problem_testcase_in_'+jml_test+'">'+
                                    '</div>'+
                                    '<label class="control-label">T'+jml_test+' Output</label>'+
                                    '<div class="controls">'+
                                        '<input type="file" name="insert_problem_testcase_out_'+jml_test+'">'+
                                    '</div>'+
                                '</div>');
            });
            
            $("#insert_remove_test").click(function() {
                var test = $("#insert_jml_test");
                var jml_test = parseInt(test.val());
                
                if(jml_test !== 0) {
                    $("div").remove("#t"+jml_test);
                    test.val(--jml_test);
                }
            });
            
            $('#insert_problem_type_upload').change(function(){
                var value = $("#insert_problem_type_upload").val();
                if(value === "1") {
                    $("#ganti").empty().html(
                        '<label class="control-label">Program</label>'+
                        '<div class="controls">'+
                            '<input type="file" name="insert_problem_program_0">'+
                        '</div>'
                    );
                } else {
                    $("#ganti").empty().html(
                        '<label class="control-label">Program</label>'+
                        '<div class="controls">'+
                            '<label>Header </label>'+
                            '<input type="file" name="insert_problem_program_0">'+
                        '</div>'+
                        '<div class="controls">'+
                            '<label>Main </label>'+
                            '<input type="file" name="insert_problem_program_1">'+
                        '</div>'+
                        '<div class="controls">'+
                            '<label>Function </label>'+
                            '<input type="file" name="insert_problem_program_2">'+
                        '</div>'
                    );
                }
            });
        });
        </script>
    </body>
</html>

