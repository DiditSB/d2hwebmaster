<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_model extends CI_Model {

//    function __construct() {
//        parent::__construct();
//    }

    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    /**
     * forgotten_password
     * Sends a 'Forgotten Password' email to a users email address. 
     * The email will contain a link that redirects the user to the site, a token within the link is verified, and the user can then manually reset their password.
     */
    function forgotten_password() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('forgot_password_identity', 'Identity (Email / Login)', 'required');

        // Run the validation.
        if ($this->form_validation->run()) {
            // The 'forgotten_password()' function will verify the users identity exists and automatically send a 'Forgotten Password' email.
            $response = $this->flexi_auth->forgotten_password($this->input->post('forgot_password_identity'));

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Redirect user.
            redirect('index');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    function login() {
        $this->load->library('form_validation');

        // Set validation rules.
        $this->form_validation->set_rules('login_identity', 'Identity Email', 'required');
        $this->form_validation->set_rules('login_password', 'Password', 'required');

        // If failed login attempts from users IP exceeds limit defined by config file, validate captcha.
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            /**
             * reCAPTCHA
             * http://www.google.com/recaptcha
             * To activate reCAPTCHA, ensure the 'recaptcha_response_field' validation below is uncommented and then comment out the 'login_captcha' validation further below.
             *
             * The custom validation rule 'validate_recaptcha' can be found in '../libaries/MY_Form_validation.php'.
             * The form field name used by 'reCAPTCHA' is 'recaptcha_response_field', this field name IS NOT editable.
             * 
             * Note: To use this example, you will also need to enable the recaptcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
             */
            $this->form_validation->set_rules('recaptcha_response_field', 'Captcha Answer', 'required|validate_recaptcha');

            /**
             * flexi auths math CAPTCHA
             * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
             * To activate Math CAPTCHA, ensure the 'login_captcha' validation below is uncommented and then comment out the 'recaptcha_response_field' validation above.
             * 
             * The field value submitted as the answer to the math captcha must be submitted to the 'validate_math_captcha' validation function.
             * The custom validation rule 'validate_math_captcha' can be found in '../libaries/MY_Form_validation.php'.
             * 
             * Note: To use this example, you will also need to enable the math_captcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
             */
            # $this->form_validation->set_rules('login_captcha', 'Captcha Answer', 'required|validate_math_captcha['.$this->input->post('login_captcha').']');				
        }

        // Run the validation.
        if ($this->form_validation->run()) {
            // Check if user wants the 'Remember me' feature enabled.
            $remember_user = ($this->input->post('remember_me') == 1);

            // Verify login data.
            $this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Reload page, if login was successful, sessions will have been created that will then further redirect verified users.
            redirect(strtolower($this->flexi_auth->get_user_group()));
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    /**
     * manual_reset_forgotten_password
     * This example lets the user manually reset their password rather than automatically sending them a new random password via email.
     * The function validates the user via a token within the url of the current site page, then validates their current and newly submitted passwords are valid.
     */
    function manual_reset_forgotten_password($user_id, $token) {
        $this->load->library('form_validation');

        // Set validation rules
        // The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
        
        // Run the validation.
        if ($this->form_validation->run()) {
            // Get password data from input.
            $new_password = $this->input->post('new_password');

            // The 'forgotten_password_complete()' function is used to either manually set a new password, or to auto generate a new password.
            // For this example, we want to manually set a new password, so ensure the 3rd argument includes the $new_password var, or else a  new password.
            // The function will then validate the token exists and set the new password.
            $this->flexi_auth->forgotten_password_complete($user_id, $token, $new_password);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            redirect('index');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    function register_account() {
        $this->load->library('form_validation');
        $group = $this->input->post('register_group');
        // Set validation rules.
        // The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        if ($group == 1 or $group == 2) {
            $validation_rules = array(
                array('field' => 'register_group', 'label' => 'User type', 'rules' => 'required'),
                array('field' => 'register_name', 'label' => 'Name', 'rules' => 'trim|required'),
                array('field' => 'register_phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|numeric'),
                array('field' => 'register_nomor_induk', 'label' => 'Nomor Induk', 'rules' => 'trim|required'),
                array('field' => 'register_email_address', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|identity_available'),
                array('field' => 'register_username', 'label' => 'Username', 'rules' => 'trim|required|min_length[4]|identity_available'),
                array('field' => 'register_password', 'label' => 'Password', 'rules' => 'trim|required|validate_password'),
                array('field' => 'register_confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[register_password]')
            );
        } else {
            $validation_rules = array(
                array('field' => 'register_group', 'label' => 'User type', 'rules' => 'required'),
                array('field' => 'register_name', 'label' => 'Name', 'rules' => 'trim|required'),
                array('field' => 'register_phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|numeric'),
                array('field' => 'register_email_address', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|identity_available'),
                array('field' => 'register_username', 'label' => 'Username', 'rules' => 'trim|required|min_length[4]|identity_available'),
                array('field' => 'register_password', 'label' => 'Password', 'rules' => 'trim|required|validate_password'),
                array('field' => 'register_confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[register_password]')
            );
        }

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get user login details from input.
            $email = $this->input->post('register_email_address');
            $username = $this->input->post('register_username');
            $password = $this->input->post('register_password');

            // Get user profile data from input.
            // You can add whatever columns you need to customise user tables.
            $profile_data = array(
                'upro_name' => $this->input->post('register_name'),
                'upro_phone' => $this->input->post('register_phone_number'),
                'upro_nomor_induk' => $this->input->post('register_nomor_induk')
            );

            // Set whether to instantly activate account.
            // This var will be used twice, once for registration, then to check if to log the user in after registration.
            $instant_activate = FALSE;

            // The last 2 variables on the register function are optional, these variables allow you to:
            // #1. Specify the group ID for the user to be added to (i.e. 'Moderator' / 'Public'), the default is set via the config file.
            // #2. Set whether to automatically activate the account upon registration, default is FALSE. 
            // Note: An account activation email will be automatically sent if auto activate is FALSE, or if an activation time limit is set by the config file.
            $response = $this->flexi_auth->insert_user($email, $username, $password, $profile_data, $group, $instant_activate);

            if ($response) {
                // This is an example 'Welcome' email that could be sent to a new user upon registration.
                // Bear in mind, if registration has been set to require the user activates their account, they will already be receiving an activation email.
                // Therefore sending an additional email welcoming the user may be deemed unnecessary.
                $email_data = array('identity' => $email);
                $this->flexi_auth->send_email($email, 'Welcome', 'registration_welcome.tpl.php', $email_data);
                // Note: The 'registration_welcome.tpl.php' template file is located in the '../views/includes/email/' directory defined by the config file.
                ###+++++++++++++++++###
                // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

                // This is an example of how to log the user into their account immeadiately after registering.
                // This example would only be used if users do not have to authenticate their account via email upon registration.
                if ($instant_activate && $this->flexi_auth->login($email, $password)) {
                    // Redirect user to public dashboard.
                    redirect('auth_public/dashboard');
                }

                // Redirect user to login page
                redirect('index/index');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

        return FALSE;
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Account Activation
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * resend_activation_token
     * Resends a new account activation token to a users email address.
     */
    function resend_activation_token() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('activation_token_identity', 'Identity Email', 'required');

        // Run the validation.
        if ($this->form_validation->run()) {
            // Verify identity and resend activation token.
            $response = $this->flexi_auth->resend_activation_token($this->input->post('activation_token_identity'));

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Redirect user.
            ($response) ? redirect('index') : redirect('index/index/resend_activation_token');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

}
