<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();

        // Load required CI libraries and helpers.
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('form');

        // Load 'standard' flexi auth library by default.
        $this->auth = new stdClass;
        $this->load->library('flexi_auth');

        if ($this->flexi_auth->is_logged_in() && uri_string() != 'index/logout') {
            // Preserve any flashdata messages so they are passed to the redirect page.
            if ($this->session->flashdata('message')) {
                $this->session->keep_flashdata('message');
            }

            // Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
            if ($this->flexi_auth->in_group('Dosen')) {
                redirect('dosen/dashboard');
            } else if ($this->flexi_auth->in_group('Mahasiswa')) {
                redirect('mahasiswa/dashboard');
            } else {
                redirect('guest/dashboard');
            }
        }

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
    }

    function activate_account($user_id, $token = FALSE) {
        // The 3rd activate_user() parameter verifies whether to check '$token' matches the stored database value.
        // This should always be set to TRUE for users verifying their account via email.
        // Only set this variable to FALSE in an admin environment to allow activation of accounts without requiring the activation token.
        $this->flexi_auth->activate_user($user_id, $token, TRUE);

        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('index');
    }

    /**
     * forgotten_password
     * Send user an email to verify their identity. Via a unique link in this email, the user is redirected to the site so they can then reset their password.
     * In this demo, this page is accessed via a link on the login page.
     *
     * Note: This is step 1 of an example of allowing users to reset a forgotten password manually. 
     * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
     */
    function forgotten_password() {
        // If the 'Forgotten Password' form has been submitted, then email the user a link to reset their password.
        if ($this->input->post('send_forgotten_password')) {
            $this->load->model('index_model');
            $this->index_model->forgotten_password();
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('index/forgot_password_view', $this->data);
    }

    function index() {
        $this->login();
    }

    function login() {
        // If 'Login' form has been submited, attempt to log the user in.
        if ($this->input->post('login_user')) {
            $this->load->model('index_model');
            $this->index_model->login();
        }

        // CAPTCHA Example
        // Check whether there are any existing failed login attempts from the users ip address and whether those attempts have exceeded the defined threshold limit.
        // If the user has exceeded the limit, generate a 'CAPTCHA' that the user must additionally complete when next attempting to login.
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            /**
             * reCAPTCHA
             * http://www.google.com/recaptcha
             * To activate reCAPTCHA, ensure the 'recaptcha()' function below is uncommented and then comment out the 'math_captcha()' function further below.
             *
             * A boolean variable can be passed to 'recaptcha()' to set whether to use SSL or not.
             * When displaying the captcha in a view, reCAPTCHA generates all html required for display. 
             * 
             * Note: To use this example, you will also need to enable the recaptcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            $this->data['captcha'] = $this->flexi_auth->recaptcha(FALSE);

            /**
             * flexi auths math CAPTCHA
             * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
             * For flexibility on CAPTCHA presentation, the 'math_captcha()' function only generates a string of the equation, see the example below.
             * 
             * To activate math_captcha, ensure the 'math_captcha()' function below is uncommented and then comment out the 'recaptcha()' function above.
             *
             * Note: To use this example, you will also need to enable the math_captcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            # $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('index/login_view', $this->data);
    }

    function logout() {
        // By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
        $this->flexi_auth->logout(FALSE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('index');
    }

    /**
     * manual_reset_forgotten_password
     * This is step 2 (The last step) of an example of allowing users to reset a forgotten password manually. 
     * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
     * In this demo, this page is accessed via a link in the 'views/includes/email/forgot_password.tpl.php' email template, which must be set to 'auth/manual_reset_forgotten_password/...'.
     */
    function manual_reset_forgotten_password($user_id = FALSE, $token = FALSE) {
        // If the 'Change Forgotten Password' form has been submitted, then update the users password.
        if ($this->input->post('change_forgotten_password')) {
            $this->load->model('index_model');
            $this->index_model->manual_reset_forgotten_password($user_id, $token);
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('index/forgot_password_update_view', $this->data);
    }

    function register_account() {
        // Redirect user away from registration page if already logged in.
        if ($this->flexi_auth->is_logged_in()) {
            redirect('index');
        }
        // If 'Registration' form has been submitted, attempt to register their details as a new account.
        else if ($this->input->post('register_user')) {
            $this->load->model('index_model', 'IM');
            $this->IM->register_account();
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('index/register_view', $this->data);
    }

    function resend_activation_token() {
        // If the 'Resend Activation Token' form has been submitted, resend the user an account activation email.
        if ($this->input->post('send_activation_token')) {
            $this->load->model('index_model', 'IM');
            $this->IM->resend_activation_token();
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('index/resend_activation_view', $this->data);
    }
    
    function upload() {
        $this->data['error'] = '';
        $this->data['data'] = '';
        if($this->input->post('file_upload')) {
            $config = array(
                'upload_path' => '../file/',
                'allowed_types' => 'pdf|c',
                'max_size' => 5120,
                'encrypt_name' => TRUE
            );
            $this->load->library('upload', $config);
            if(!$this->upload->do_upload()) {
                $this->data['error'] = $this->upload->display_errors();

                $this->load->view('upload_form', $this->data);
            } else {
                $this->data['data'] = $this->upload->data();

                $this->load->view('upload_form', $this->data);
            }
        } else {
            $this->load->view('upload_form', $this->data);
        }
    }
    
    function download($file) {
        $this->load->helper('download');
        
        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/file/'.$file.'.pdf'); // Read the file's contents
        $name = 'coba.pdf';

        force_download($name, $data);
    }

}