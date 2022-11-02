<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        $data = array(
            'title'     => "Login",
            'css'       => 'assets/css/login-style.css',
            'content'   => 'users/signin'
        );

        $this->authorized($user, $data);
    }

    public function register()
    {
        $user = $this->session->userdata('user');

        $data = array(
            'title'     => "Register",
            'css'       => 'assets/css/login-style.css',
            'content'   => 'users/signup'
        );

        $this->authorized($user, $data);
    }

    public function logoff()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function process_signin()
    {
        if ($this->form_validation->run('signin') === FALSE) {
            $this->session->set_flashdata('msg', validation_errors('<p class="error">', '</p>'));
            redirect("login");
            exit();
        }

        $form_data = $this->input->post(NULL, TRUE);
        $user = $this->user->get_user_by_email($form_data['email']);
        $match = $this->user->validate_signin_match($user, $form_data['password']);

        if ($match === FALSE) {
            $this->session->set_flashdata('msg', '<p class="error">Invalid Credentials</p>');
            redirect("login");
            exit();
        }

        $user_session = array(
            "id"        => $user['id'],
            "user"      => $user['first_name'] . ' ' . $user['last_name'],
            "email"     => $user['email'],
            "is_admin"  => $user['is_admin']
        );

        $this->session->set_userdata("user", $user_session);
        redirect("products");
    }

    public function process_signup()
    {
        if ($this->form_validation->run('signup') === FALSE) {
            $this->session->set_flashdata('msg', validation_errors('<p class="error">', '</p>'));
            redirect("register");
            exit();
        }

        $form_data = $this->input->post(NULL, TRUE);

        if ($this->user->add_new_user($form_data)) {
            $this->session->set_flashdata("msg", "<p class='message'>User created Successfully</p>");
            redirect("login");
            exit();
        }

        redirect("register");
    }

    private function authorized($user, $data)
    {
        if ($user) {
            if ($user['is_admin'] == 1) {
                redirect('dashboard/products');
            } else {
                redirect('products');
            }
        } else {
            $this->set_template($data);
        }
    }

    private function set_template($data)
    {
        if (isset($data['title'])) {
            $this->template->title = $data['title'];
        }
        if (isset($data['css'])) {
            $this->template->stylesheet->add($data['css']);
        }
        $this->template->content->view($data['content']);
        $this->template->publish();
    }
}
