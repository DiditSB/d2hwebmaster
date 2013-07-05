<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen_model extends CI_Model {

    // The following method prevents an error occurring when $this->data is modified.
    // Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }
    
    function get_problems($status) {
        // Select user data to be displayed.
        $sql_select = array(
            'problem_id',
            'problem_title',
            'problem_orig_name',
            'problem_date_added',
            'problem_active'
        );
        $sql_where['problem_active'] = ($status == 'inactive') ? 0 : 1;
        $this->flexi_auth->sql_select($sql_select);
        $this->flexi_auth->sql_where($sql_where);
        $this->flexi_auth->sql_order_by('dosen_problems.problem_date_added', 'DESC');

        // Get url for any search query or pagination position.
        $uri = $this->uri->uri_to_assoc(4);

        // Set pagination limit, get current position and get total users.
        $limit = 10;
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;

        // Set SQL WHERE condition depending on whether a user search was submitted.
        if (array_key_exists('search', $uri)) {
            // Set pagination url to include search query.
            $pagination_url = 'dosen/list_problems/search/' . $uri['search'] . '/';
            $config['uri_segment'] = 7; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.
            // Convert uri '-' back to ' ' spacing.
            $search_query = str_replace('-', ' ', $uri['search']);

            // Get users and total row count for pagination.
            // Custom SQL SELECT, WHERE and LIMIT statements have been set above using the sql_select(), sql_where(), sql_limit() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $total_users = $this->flexi_auth->get_custom_user_data_query($search_query)->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['problems'] = $this->flexi_auth->get_custom_user_data_array($search_query);
        } else {
            // Set some defaults.
            $pagination_url = 'dosen/list_problems/';
            $search_query = FALSE;
            $config['uri_segment'] = 5; // Changing to 4 will select the 4th segment, example 'controller/function/page/10'.
            // Get users and total row count for pagination.
            // Custom SQL SELECT and WHERE statements have been set above using the sql_select() and sql_where() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $total_users = $this->flexi_auth->get_custom_user_data_query()->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['problems'] = $this->flexi_auth->get_custom_user_data_array();
            //print_r($this->data['users']); exit();
        }

        // Create user record pagination.
        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_users,
            'per_page' => $limit,
            'num_links' => 10,
            'full_tag_open' => '<div class="pagination"><ul>',
            'full_tag_close' => '</ul></div>',
            'first_link' => 'First',
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'last_link' => 'Last',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'next_link' => 'Â»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'prev_link' => 'Â«',
            'prev_tag_open' => '<li>',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        );
        $this->pagination->initialize($config);

        // Make search query and pagination data available to view.
        $this->data['search_query'] = $search_query; // Populates search input field in view.
        $this->data['pagination']['links'] = $this->pagination->create_links();
        $this->data['pagination']['total_users'] = $total_users;
    }

    /**
     * Insert Problem Model
     * Inserting Problem into 'problems' table
     */
    function insert_problem() {
        $this->data['type_upload'] = $this->input->post('insert_problem_type_upload');
        $this->data['error_upload_file'] = 'Upload again';
        $this->load->library('form_validation');

        // Set validation rules.
        $validation_rules = array(
            array('field' => 'insert_problem_title', 'label' => 'Title', 'rules' => 'required'),
            array('field' => 'insert_problem_type', 'label' => 'Type', 'rules' => 'required'),
            array('field' => 'insert_problem_difficulty', 'label' => 'Difficulty', 'rules' => 'required'),
            array('field' => 'insert_problem_date_start', 'label' => 'Date Start', 'rules' => 'required'),
            array('field' => 'insert_problem_date_end', 'label' => 'Date End', 'rules' => 'required'),
            array('field' => 'insert_problem_type_upload', 'label' => 'Type Upload', 'rules' => 'required'),
            array('field' => 'insert_problem_time_limit', 'label' => 'Time Limit', 'rules' => 'required|integer'),
            array('field' => 'insert_problem_memory_limit', 'label' => 'Memory Limit', 'rules' => 'required|integer'),
            array('field' => 'insert_jml_test', 'label' => 'Jumlah Test', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        // Run the validation.
        if ($this->form_validation->run()) {
            $config0 = array(
                'upload_path' => '../dosen/problems/',
                'allowed_types' => 'pdf',
                'max_size' => 5120,
                'encrypt_name' => TRUE
            );

            $this->load->library('upload');
            $this->upload->initialize($config0);

            if (!$this->upload->do_upload('insert_problem_file')) {
                // Displaying error if upload failed
                $this->data['upload_error_problem'] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
            } else {
                $problem_title = $this->input->post('insert_problem_title');
                $path_program = '../dosen/programs/'.$problem_title.'/';
                
                // make folder inside dosen/programs/ use title as a name
                if(!mkdir($path_program, 0755)) {
                    // if failed show error message
                    $this->data['message'] = 'Failed to create folders...';
                    return FALSE;
                }
                
                $config1 = array(
                    'upload_path' => $path_program,
                    'allowed_types' => 'c|C|h|H',
                    'max_size' => 2048,
                    'encrypt_name' => TRUE
                );
                
                // Get details uploaded data
                $data_uploaded_file_problem = $this->upload->data();
                
                $this->upload->initialize($config1);
                
                $problem_programs = $this->input->post('insert_problem_type_upload');
                for($i = 0; $i < $problem_programs; $i++) {
                    if (!$this->upload->do_upload('insert_problem_program_'.$i)) {
                        // Displaying error if upload failed
                        $this->data["upload_error_program_".$i] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                        return FALSE;
                    } else { 
                        // Get details uploaded data
                        $data_uploaded_file_programs[$i] = $this->upload->data();
                    }
                }
                
                // Delete all uploaded program if failed to upload ....??
                
                $config2 = array(
                    'upload_path' => $path_program,
                    'allowed_types' => 'txt',
                    'max_size' => 2048,
                    'encrypt_name' => TRUE
                );
                
                $problem_testcase_in = $this->input->post('insert_jml_test');
                $problem_testcase_out = $this->input->post('insert_jml_test');
                
                for($i = 0; $i <= $problem_testcase_in; $i++) {
                    $config2['file_name'] = 't'.$i.'_in';
                    $this->upload->initialize($config2);
                    
                    if (!$this->upload->do_upload('insert_problem_testcase_in_'.$i)) {
                        // Displaying error if upload failed
                        $this->data["upload_error_testcase_in_".$i] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                        return FALSE;
                    } else { 
                        // Get details uploaded data
                        $data_uploaded_file_testcase_in[$i] = $this->upload->data();
                        $i++;
                    }
                }
                
                for($i = 0; $i <= $problem_testcase_out; $i++) {
                    $config2['file_name'] = 't'.$i.'_out';
                    $this->upload->initialize($config2);
                    
                    if (!$this->upload->do_upload('insert_problem_testcase_out_'.$i)) {
                        // Displaying error if upload failed
                        $this->data["upload_error_testcase_out_".$i] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                        return FALSE;
                    } else { 
                        // Get details uploaded data
                        $data_uploaded_file_testcase_out[$i] = $this->upload->data();
                        $i++;
                    }
                }
                
                // Get user id from session to use in the insert function as a primary key.
                $user_id = $this->flexi_auth->get_user_id();
                
                $arr_str_replace = array('-', ':', ' '); // array for replace
                $date_start = $this->input->post('insert_problem_date_start');
                $date_end = $this->input->post('insert_problem_date_end');
                $date_now = date('Y-m-d H:i:s', time());
                $problem_date_start = str_replace($arr_str_replace, '', $date_start); // make 2013-03-22 10:21:23 to 20130322102123
                $problem_date_end = str_replace($arr_str_replace, '', $date_end); // make 2013-03-22 10:21:23 to 20130322102123
                $now = str_replace($arr_str_replace, '', $date_now); // make 2013-03-22 10:21:23 to 20130322102123
                
                if($now >= $problem_date_start && $now <= $problem_date_end) { // compare date time to check problem active or not
                    $problem_active = 1; 
                } else {
                    $problem_active = 0;
                }
                
                $problem_data = array(
                    'problem_uacc_fk' => $user_id,
                    'problem_title' => $problem_title,
                    'problem_type' => $this->input->post('insert_problem_type'),
                    'problem_difficulty' => $this->input->post('insert_problem_difficulty'),
                    'problem_file_name' => $data_uploaded_file_problem['file_name'],
                    'problem_orig_name' => $data_uploaded_file_problem['orig_name'],
                    'problem_file_path' => $data_uploaded_file_problem['file_path'],
                    'problem_time_limit' => $this->input->post('insert_problem_time_limit'),
                    'problem_memory_limit' => $this->input->post('insert_problem_memory_limit'),
                    'problem_type_upload' => $this->input->post('insert_problem_type_upload'),
                    'problem_active' => $problem_active,
                    'problem_date_added' => $date_now,
                    'problem_date_start' => $date_start,
                    'problem_date_end' => $date_end,
                    'problem_view' => ''
                );

                $response = $this->db->insert('dosen_problems', $problem_data);
                if(!$response) {
                    // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                    $this->session->set_flashdata('message', 'Unable to insert problem');
                    
                    // Redirect user.
                    ($response) ? redirect('dosen') : redirect('dosen/insert_problem');
                }
                
                $insert_id = $this->db->insert_id();
                foreach($data_uploaded_file_programs as $row) {
                    $arr_program = array(
                        'program_problems_fk' => $insert_id,
                        'program_file_name' => $row['file_name'],
                        'program_orig_file_name' => $row['orig_name'],
                        'program_file_path' => $row['file_path']
                    );
                    
                    $response = $this->db->insert('dosen_problem_programs', $arr_program);
                    if(!$response) {
                        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                        $this->session->set_flashdata('message', 'Unable to insert problem');

                        // Redirect user.
                        redirect('dosen/insert_problem');
                    }
                }
                
                foreach($data_uploaded_file_testcase_in as $row) {
                    $arr_program = array(
                        'program_problems_fk' => $insert_id,
                        'program_file_name' => $row['file_name'],
                        'program_orig_file_name' => $row['orig_name'],
                        'program_file_path' => $row['file_path']
                    );
                    
                    $response = $this->db->insert('dosen_problem_programs', $arr_program);
                    if(!$response) {
                        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                        $this->session->set_flashdata('message', 'Unable to insert problem');

                        // Redirect user.
                        redirect('dosen/insert_problem');
                    }
                }
                
                foreach($data_uploaded_file_testcase_out as $row) {
                    $arr_program = array(
                        'program_problems_fk' => $insert_id,
                        'program_file_name' => $row['file_name'],
                        'program_orig_file_name' => $row['orig_name'],
                        'program_file_path' => $row['file_path']
                    );
                    
                    $response = $this->db->insert('dosen_problem_programs', $arr_program);
                    if(!$response) {
                        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                        $this->session->set_flashdata('message', 'Unable to insert problem');

                        // Redirect user.
                        redirect('dosen/insert_problem');
                    }
                }
                
                redirect('dosen');
            }
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="alert alert-info">', '</p>');

            return FALSE;
        }
    }

}
