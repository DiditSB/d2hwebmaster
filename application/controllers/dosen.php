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

        if (!$this->flexi_auth->is_logged_in() || $this->flexi_auth->get_user_group_id() != 2) {
            // Set a custom error message.
            $this->flexi_auth->set_error_message('You must login as an dosen to access this area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('index');
        }

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
    }
    
    /**
     * dashboard
     * Dosen main index page
     */
    function dashboard() {
        $this->data['message'] = $this->session->flashdata('message');
        $this->load->view('dosen/dashboard_view', $this->data);
    }

    /**
     * index
     * Forwards to the admin dashboard.
     */
    function index() {
        redirect('dosen/dashboard');
    }
    
    /**
     * insert_problem
     * Insert new problem
     */
    function insert_problem() {
        $this->load->helper('file');
        if($this->flexi_auth->is_privileged('Insert Problem')) {
            // If 'Add Problem' form has been submitted, then insert the new problem details to the problems table.
            if($this->input->post('insert_problem')) {
                $this->load->model('dosen_model');
                $this->dosen_model->insert_problem();
            }
        }
        
        // Set any returned status/error messages.
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        
        $this->load->view('dosen/insert_problem_view', $this->data);
    }
    
    function list_problems($status = FALSE) {
        $this->load->model('dosen_model');

        // Check user has privileges to view user accounts, else display a message to notify the user they do not have valid privileges.
        if (!$this->flexi_auth->is_privileged('View Users')) {
            $this->session->set_flashdata('message', '<p>You do not have privileges to view user accounts.</p>');
            redirect('dosen');
        }

        // If 'Admin Search User' form has been submitted, this example will lookup the users email address and first and last name.
        if ($this->input->post('search_problems') && $this->input->post('search_query')) {
            // Convert uri ' ' to '-' spacing to prevent '20%'.
            // Note: Native php functions like urlencode() could be used, but by default, CodeIgniter disallows '+' characters.
            $search_query = str_replace(' ', '-', $this->input->post('search_query'));

            // Assign search to query string.
            redirect('dosen/list_problems/search/' . $search_query . '/page/');
        }
        
        // If 'Manage User Accounts' form has been submitted and user has privileges to update user accounts, then update the account details.
        else if ($this->input->post('update_problems') && $this->flexi_auth->is_privileged('Update Users')) {
            $this->dosen_model->update_user_accounts();
        }
        
        // The view associated with this controller method is used by multiple methods, therefore set a page title.
        $this->data['page_title'] = ($status == 'inactive') ? 'Inactive Problems' : 'Active Problems';
        $this->data['status'] = ($status == 'inactive') ? 'inactive_problems' : 'active_problems'; // Indicate page function.
        // Get an array of all active/inactive user accounts, using the sql select and where statements defined below.
        // Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
        // Read more on 'db_column()' functions in the quick help section near the top of this controller.

        // Get user account data for all users. 
        // If a search has been performed, then filter the returned users.
        $this->dosen_model->get_problems($status);

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('dosen/manage_problems_view', $this->data);
    }
}
