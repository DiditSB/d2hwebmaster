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
            $config1 = array(
                'upload_path' => '../file/',
                'allowed_types' => 'pdf',
                'max_size' => 5120,
                'encrypt_name' => TRUE
            );

            $this->load->library('upload');
            $this->upload->initialize($config1);

            if (!$this->upload->do_upload('insert_file_problem')) {
                // Displaying error if upload failed
                $this->data['upload_error'] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
            } else {
                $config2 = array(
                    'upload_path' => '../file/',
                    'allowed_types' => 'pdf',
                    'max_size' => 5120,
                    'encrypt_name' => TRUE
                );
                
                // Get details file1 uploaded data
                $file1 = $this->upload->data();
                
                $this->upload->initialize($config1);
                
                if (!$this->upload->do_upload('insert_file_problem')) {
                    // Delete first file if the second file failed to upload
                    unlink($file1['full_path']);
                    
                    // Displaying error if upload failed
                    $this->data['upload_error'] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
                } else {
               
                    // Get details file2 uploaded data
                    $file2 = $this->upload->data();

                    $problem_data = array(
                        'problem_file_name' => $file1['file_name'],
                        'problem_orig_name' => $file1['orig_name'],
                        'problem_file_path' => $file1['file_path'],
                        'problem_active' => '',
                        'problem_date_added' => date('Y-m-d H:i:s', time()),
                        'problem_date_start' => '',
                        'problem_date_end' => ''
                    );

                    $response = $this->flexi_auth->insert_custom_user_data(2, $problem_data);

                    // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                    $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

                    // Redirect user.
                    ($response) ? redirect('dosen') : redirect('dosen/insert_problem');
                }
            }
//        $this->load->library('form_validation');
//
//        // Set validation rules.
//        $validation_rules = array(
//            array('field' => 'insert_date_start', 'label' => 'Date Start', 'rules' => 'required'),
//            array('field' => 'insert_date_end', 'label' => 'Date End', 'rules' => 'required')
//        );
//
//        $this->form_validation->set_rules($validation_rules);
//        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
//
//        // Run the validation.
//        if ($this->form_validation->run()) {
//            $config = array(
//                'upload_path' => '../file/',
//                'allowed_types' => 'pdf',
//                'max_size' => 5120,
//                'encrypt_name' => TRUE
//            );
//
//            $this->load->library('upload');
//            $this->upload->initialize($config);
//
//            if (!$this->upload->do_upload('insert_file_problem')) {
//                // Displaying error if upload failed
//                $this->data['upload_error'] = $this->upload->display_errors('<p class="alert alert-info">', '</p>');
//            } else {
//                // Get details uploaded data
//                $data_uploaded = $this->upload->data();
//
//                // Get user id from session to use in the insert function as a primary key.
//                $user_id = $this->flexi_auth->get_user_id();
//
//                $problem_data = array(
//                    'problem_file_name' => $data_uploaded['file_name'],
//                    'problem_orig_name' => $data_uploaded['orig_name'],
//                    'problem_file_path' => $data_uploaded['file_path'],
//                    'problem_active' => '',
//                    'problem_date_added' => date('Y-m-d H:i:s', time()),
//                    'problem_date_start' => $this->input->post('insert_date_start'),
//                    'problem_date_end' => $this->input->post('insert_date_end')
//                );
//
//                $response = $this->flexi_auth->insert_custom_user_data($user_id, $problem_data);
//
//                // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
//                $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
//
//                // Redirect user.
//                ($response) ? redirect('dosen') : redirect('dosen/insert_problem');
//            }
//        } else {
//            // Set validation errors.
//            $this->data['message'] = validation_errors('<p class="alert alert-info">', '</p>');
//
//            return FALSE;
//        }
    }

}
