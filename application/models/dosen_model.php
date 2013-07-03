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
