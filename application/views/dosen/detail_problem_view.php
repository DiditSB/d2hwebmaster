
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url('dosen/list_problems'); ?>"><i class="icon-th"></i> List all problems</a></li>
                        <li>
                            <span class="divider">\</span><a href="<?php echo current_url(); ?>">Detail problem</a>
                        </li>
                    </ul>
                    <div class="namespace-indent">
                        <h3>Detail Problem '<?php echo $problem->problem_title; ?>'</h3>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-success" style="text-align: center">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="element" style="background-color: white">
                            <h3 style="text-align: center"><?php echo $problem->problem_title; ?></h3>
                            <hr />
                            <table class="table" style="border-width: 0">
                                <tr>
                                    <td>Type</td>
                                    <td>: <?php echo $problem->problem_type; ?></td>
                                    <td>Difficulty</td>
                                    <td>: <?php echo $problem->problem_difficulty; ?></td>
                                </tr>
                                <tr>
                                    <td>Time Limit</td>
                                    <td>: <?php echo $problem->problem_time_limit; ?></td>
                                    <td>Memory Limit</td>
                                    <td>: <?php echo $problem->problem_memory_limit; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: <?php echo ($problem->problem_active) ? 'Active' : 'Inactive'; echo ' ('.$problem->problem_date_start.' s/d '.$problem->problem_date_end.')'; ?></td>
                                    <td>Date Added</td>
                                    <td>: <?php echo $problem->problem_date_added; ?></td>
                                </tr>
                            </table>
                            <?php
                                //$problem_path = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/dosen/problems/";
                                $problem_path = "114.79.61.103/dosen/problems/";
                                $problem_path = urlencode($problem_path);
                            ?>
                            <iframe src="http://docs.google.com/viewer?url=<?php echo $problem_path.$problem->problem_file_name; ?>&embedded=true" width="825" height="780" style="border: none;"></iframe>
                            <table class="table" style="border-width: 0">
                                <tr>
                                    <td>Download Problem</td>
                                    <td colspan="3">: <a href="<?php echo site_url('dosen/download/problem/'.$problem->problem_file_name); ?>" class="btn">Problem</a></td>
                                </tr>
                                <tr>
                                    <td>Download Program</td>
                                    <?php if($problem->problem_type_upload == 1) { ?>
                                    <td colspan="3">: <a href="<?php echo site_url('dosen/download/program/'.$program[0]->program_file_name); ?>" class="btn">Main</a></td>
                                    <?php } else { ?>
                                    <td colspan="3">: 
                                        <a href="<?php echo site_url('dosen/download/program/'.$program[0]->program_file_name); ?>" class="btn">Header</a>
                                        <a href="<?php echo site_url('dosen/download/program/'.$program[1]->program_file_name); ?>" class="btn">Main</a> 
                                        <a href="<?php echo site_url('dosen/download/program/'.$program[2]->program_file_name); ?>" class="btn">Fungsi</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php for($i = $problem->problem_type_upload; $i <= ($problem->problem_testcase + $problem->problem_type_upload); $i++) { ?>
                                <tr>
                                    <td>Download Testcase <?php echo $i - $problem->problem_type_upload; ?></td>
                                    <td colspan="3">: 
                                        <a href="<?php echo site_url('dosen/download/program/'.$program[$i]->program_file_name); ?>" target="_blank" class="btn">t<?php echo $i - $problem->problem_type_upload; ?>_in</a> 
                                        <a href="<?php echo site_url('dosen/download/program/'.$program[$i + 1 + $problem->problem_testcase]->program_file_name); ?>" target="_blank" class="btn">t<?php echo $i - $problem->problem_type_upload; ?>_out</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
            
