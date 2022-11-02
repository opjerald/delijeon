<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function get_user_by_email($email = '')
    {
        $query = 'SELECT * FROM users WHERE email = ?';
        return $this->db->query($query, $this->security->xss_clean($email))->row_array();
    }

    public function add_new_user($data)
    {
        $users = $this->db->query('SELECT * FROM users')->result_array();

        $is_admin = empty($users) ? 1 : 0;

        $values = array(
            $this->security->xss_clean($data['first_name']),
            $this->security->xss_clean($data['last_name']),
            $this->security->xss_clean($data['email']),
            $this->security->xss_clean(md5($data['confirm_password'])),
            $this->security->xss_clean($is_admin),
        );

        $query = 'INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (?,?,?,?,?, NOW())';
        return $this->db->query($query, $values);
    }

    public function validate_signin_match($user, $password)
    {
        $has_password = md5($this->security->xss_clean($password));
        if ($user && $user['password'] == $has_password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
