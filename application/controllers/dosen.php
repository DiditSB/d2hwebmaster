<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dosen extends CI_Controller {

    function __construct() {
        parent::__construct();

        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        // Load required CI libraries and helpers.
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

        // Check user is logged in as an admin.
        // For security, admin users should always sign in via Password rather or 'Remember me'.
//        if (!$this->flexi_auth->is_logged_in() || $this->flexi_auth->get_user_group_id() != 2) {
//            // Set a custom error message.
//            $this->flexi_auth->set_error_message('You must login as an dosen to access this area.', TRUE);
//            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
//            redirect('index');
//        }

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
    }

    /**
     * index
     * Forwards to the admin dashboard.
     */
    function index() {
        $this->data['message'] = $this->session->flashdata('message');
        $this->load->view('dosen/dashboard_view', $this->data);
    }
    
    /**
     * insert_problem
     * Insert new problem
     */
    function insert_problem() {
        // If 'Add Problem' form has been submitted, then insert the new problem details to the problems table.
        if($this->input->post('add_problem')) {
            $this->load->model('dosen_model');
            $this->dosen_model->insert_problem();
        }
        
        // Set any returned status/error messages.
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        
        $this->load->view('dosen/insert_problem_view', $this->data);
    }
}
