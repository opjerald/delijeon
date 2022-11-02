<?php

class Hero extends Widget
{
    public function display()
    {
        $user = $this->session->userdata("user");
        $data['selected_menu'] = $this->session->userdata("selected_menu");

        if ($user && $user['is_admin'] == 0 && $data['selected_menu']) {
            $this->view('widgets/hero',  $data['selected_menu']);
        }
    }
}
