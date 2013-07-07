<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dosen_model extends CI_Model {

    // The following method prevents an error occurring when $this->data is modified.
    // Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }
    
    function detail($type, $id) {
        // Get user id from session to use in the insert function as a primary key.
        $user_id = $this->flexi_auth->get_user_id();
        
        if($type == 'problem') {
            // update
            // update inactive problem
            $sql_select = array(
                'problem_date_end'
            );
            $sql_where['problem_id'] = $id;
            $this->flexi_auth->sql_select($sql_select);
            $this->flexi_auth->sql_where($sql_where);
            $problems = $this->flexi_auth->get_custom_user_data_array();
            $this->db->flush_cache();
            foreach($problems as $problem) {
                
                $this->update_status_problem_by_id($problem['problem_date_end'], $id);
            }
            
            $this->db->select('*');
            $this->db->from('dosen_problems');
            //$this->db->join('dosen_problem_programs', 'dosen_problem_programs.program_problems_fk = problem_id');
            $this->db->where('problem_id', $id);
            $this->db->where('problem_uacc_fk', $user_id);
            $query0 = $this->db->get();
            $this->db->flush_cache();
            
            $this->db->select('*');
            $this->db->from('dosen_problem_programs');
            //$this->db->join('dosen_problem_programs', 'dosen_problem_programs.program_problems_fk = problem_id');
            $this->db->where('program_problems_fk', $id);
            $query1 = $this->db->get();
            $this->db->flush_cache();
            
            if ($query0->num_rows() > 0) {
                $i = 0;
                foreach($query1->result() as $row) {
                    $this->data['program'][$i] = $row;
                    $i++;
                }
//                print_r($query1->result());
//                return FALSE;
                $this->data['problem'] = $query0->row();
            }
            
        } else if($type == 'mahasiswa') {
            // do something
        } else {
            $this->session->set_flashdata('message', "Page you are looking for doesn't exist");
                
            redirect('dosen');
        }
    }
    
    function download($type, $name) {
        if($type == 'problem') {
            $this->db->select('problem_orig_name, problem_file_path');
            $query = $this->db->get_where('dosen_problems', array('problem_file_name' => $name));
            $result = $query->row();
            $data = file_get_contents($result->problem_file_path.$name); // Read the file's contents

            force_download($result->problem_orig_name, $data);
        } else if($type == 'program') {
            $this->db->select('program_orig_file_name, program_file_path');
            $query = $this->db->get_where('dosen_problem_programs', array('program_file_name' => $name));
            $result = $query->row();
            
            $data = file_get_contents($result->program_file_path.$name); // Read the file's contents

            force_download($result->program_orig_file_name, $data);
        }
    }
    
    function problem_typeahead() {
        $q = $this->input->post('query');
        $user_id = $this->flexi_auth->get_user_id();
        
        $this->db->select('problem_title');
        $this->db->like('problem_title', $q);
        $query = $this->db->get_where('dosen_problems', array('problem_uacc_fk' => $user_id));
        
        $result = array();
        foreach ($query->result() as $row) {
            array_push($result, $row->problem_title);
        }
        return $result;
    }
    
    function update_status_problem() {
        $this->db->start_cache();
        $this->db->where('problem_date_start <=', date('Y-m-d H:i:s', time()));
        $this->db->where('problem_date_end >=', date('Y-m-d H:i:s', time()));
        $this->db->update('dosen_problems', array('problem_active' => 1));
        $this->db->stop_cache();
        $this->db->flush_cache();
        
        $this->db->start_cache();
        $this->db->where('problem_date_end <=', date('Y-m-d H:i:s', time()));
        $this->db->update('dosen_problems', array('problem_active' => 2));
        $this->db->stop_cache();
        $this->db->flush_cache();
    }
    
    function update_status_problem_by_id($date_end, $problem_id) {
        $arr_str_replace = array('-', ':', ' '); // array for replace
        $date_now = date('Y-m-d H:i:s', time());
        $problem_date_end = str_replace($arr_str_replace, '', $date_end); // make 2013-03-22 10:21:23 to 20130322102123
        $now = str_replace($arr_str_replace, '', $date_now); // make 2013-03-22 10:21:23 to 20130322102123

        if($problem_date_end < $now) {
            $this->db->where('problem_id', $problem_id);
            $this->db->update('dosen_problems', array('problem_active' => 2));
            $this->db->flush_cache();
        }
    }
            
    function get_problems() {
        // Get user id from session to use in the insert function as a primary key.
        $user_id = $this->flexi_auth->get_user_id();
        
        // Select user data to be displayed.
        $sql_select = array(
            'problem_id',
            'problem_title',
            'problem_date_added',
            'problem_active'
        );
        $this->db->select('problem_id, problem_title, problem_orig_name, problem_date_added, problem_active');
        $this->db->where('problem_uacc_fk', $user_id);

        // Get url for any search query or pagination position.
        $uri = $this->uri->uri_to_assoc(3);

        // Set pagination limit, get current position and get total users.
        $limit = 10;
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;

        // Set SQL WHERE condition depending on whether a user search was submitted.
        if (array_key_exists('search', $uri)) {
            // Set pagination url to include search query.
            $pagination_url = 'dosen/list_problems/search/' . $uri['search'] . '/';
            $config['uri_segment'] = 6; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.
            // Convert uri '-' back to ' ' spacing.
            $search_query = str_replace('-', ' ', $uri['search']);
            $this->db->where('problem_title', $search_query);
            // Get users and total row count for pagination.
            // Custom SQL SELECT, WHERE and LIMIT statements have been set above using the sql_select(), sql_where(), sql_limit() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $this->db->order_by('problem_date_added', 'DESC');
            $query = $this->db->get('dosen_problems', $limit, $offset);
            $total_users = $query->num_rows();

            $this->data['problems'] = $query->result_array();
        } else {
            // Set some defaults.
            $pagination_url = 'dosen/list_problems/';
            $search_query = FALSE;
            $config['uri_segment'] = 4; // Changing to 4 will select the 4th segment, example 'controller/function/page/10'.
            // Get users and total row count for pagination.
            // Custom SQL SELECT and WHERE statements have been set above using the sql_select() and sql_where() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $this->db->order_by('problem_date_added', 'DESC');
            $query = $this->db->get('dosen_problems', $limit, $offset);
            $total_users = $query->num_rows();

            $this->data['problems'] = $query->result_array();
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
            array('field' => 'insert_problem_title', 'label' => 'Title', 'rules' => 'required|title_available'),
            array('field' => 'insert_problem_type', 'label' => 'Type', 'rules' => 'required'),
            array('field' => 'insert_problem_difficulty', 'label' => 'Difficulty', 'rules' => 'required'),
            array('field' => 'insert_problem_date_start', 'label' => 'Date Start', 'rules' => 'required'),
            array('field' => 'insert_problem_date_end', 'label' => 'Date End', 'rules' => 'required'),
            array('field' => 'insert_problem_type_upload', 'label' => 'Type Upload', 'rules' => 'required'),
            array('field' => 'insert_problem_time_limit', 'label' => 'Time Limit', 'rules' => 'required|integer'),
            array('field' => 'insert_problem_memory_limit', 'label' => 'Memory Limit', 'rules' => 'required|integer'),
            array('field' => 'insert_jml_test', 'label' => 'Jumlah Test', 'rules' => 'required|integer')
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
                
                // Get details uploaded data
                $data_uploaded_file_problem = $this->upload->data();
                
                $problem_programs = $this->input->post('insert_problem_type_upload');
                
                $config1 = array(
                    'upload_path' => $path_program,
                    'max_size' => 2048,
                    'encrypt_name' => TRUE
                );
                
                if($problem_programs == 1) {
                    $config1['allowed_types'] = 'c|C';
                } else {
                    $config1['allowed_types'] = 'c|C|h|H';
                }
                
                $this->upload->initialize($config1);
                
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
                
                $problem_testcase = $this->input->post('insert_jml_test');
                
                for($i = 0; $i <= $problem_testcase; $i++) {
                    $config2['file_name'] = 't'.$i.'_in';
                    $this->upload->initialize($config2);
                    
                    if (!$this->upload->do_upload('insert_problem_testcase_in_'.$i)) {
                        // Displaying error if upload failed
                        $this->data["upload_error_testcase_in_".$i] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                        return FALSE;
                    } else { 
                        // Get details uploaded data
                        $data_uploaded_file_testcase_in[$i] = $this->upload->data();
                    }
                }
                
                for($i = 0; $i <= $problem_testcase; $i++) {
                    $config2['file_name'] = 't'.$i.'_out';
                    $this->upload->initialize($config2);
                    
                    if (!$this->upload->do_upload('insert_problem_testcase_out_'.$i)) {
                        // Displaying error if upload failed
                        $this->data["upload_error_testcase_out_".$i] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                        return FALSE;
                    } else { 
                        // Get details uploaded data
                        $data_uploaded_file_testcase_out[$i] = $this->upload->data();
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
                
                if($problem_date_start == '00000000000000' && $problem_date_end == '00000000000000' || $now >= $problem_date_start && $now <= $problem_date_end) { // compare date time to check problem active or not
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
                    'problem_testcase' => $problem_testcase,
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
                
                $this->session->set_flashdata('message', 'Success to add the problem');
                
                redirect('dosen');
            }
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="alert alert-info">', '</p>');
            
            return FALSE;
        }
    }

}
