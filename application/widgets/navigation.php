<?php

class Navigation extends Widget
{
    public function display()
    {
        $this->load->model('cart');
        $user = $this->session->userdata("user");
        $data['selected_menu'] = $this->session->userdata('selected_menu');

        if ($user && $user['is_admin'] == 0 && $data['selected_menu']) {
            $cart_count = $this->cart->cart_count($user['id']) ?? 0;
            $data['menus'] = array(
                array(
                    "url" => "home",
                    "name" => "Home",
                    "icon" => "bi bi-house-heart"
                ),
                array(
                    "url" => "shop",
                    "name" => "Shop",
                    "icon" => "bi bi-basket"
                ),
                'title',
                array(
                    "url" => "cart",
                    "name" => "Cart(<span class='cart_count'>$cart_count</span>)",
                    "icon" => "bi bi-cart"
                ),
                array(
                    "url" => "users/logoff",
                    "name" => "Logout",
                    "icon" => "bi bi-box-arrow-left"
                ),
            );
            $this->view('widgets/navigation', $data);
        }

        if ($user && $user['is_admin'] == 1) {
            $data['menus'] = array(
                array(
                    "url" => "dashboard/products",
                    "name" => "Products",
                ),
                array(
                    "url" => "dashboard/orders",
                    "name" => "Orders",
                ),
                array(
                    "url" => "users/logoff",
                    "name" => "Logoff",
                )
            );
            $this->view('widgets/admin_navigation', $data);
        }
    }
}
