<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->session->set_userdata("selected_menu", array("menu" => "Cart", "hero" => "Cart"));
        $user = $this->session->userdata('user');

        $data = array(
            "title"     => "Delijeon - Cart",
            "js"        => "assets/js/user/cart.js",
            "content"   => array(
                "view"  => "carts/index",
                "data"  => array(
                    "products" => $this->cart->get_all($user['id']),
                    "total_price" => $this->cart->total_price($user['id']) ?? 0,
                ),
            )
        );

        $this->authorize($user, $data);
    }

    public function checkout()
    {
        $this->session->unset_userdata('selected_menu');
        $user = $this->session->userdata('user');

        $data = array(
            "title"     => "Delijeon - Checkout",
            "js"        => array(
                "assets/js/user/checkout.js",
                "https://js.stripe.com/v2/",
            ),
            "content"   => array(
                "view"  => "carts/checkout",
                "data"  => array(
                    "products" => $this->cart->get_all($user['id']),
                    "total_price" => $this->cart->total_price($user['id']) ?? 0,
                    "email" => $user['email']
                ),
            )
        );

        $this->authorize($user, $data);
    }

    public function order_success()
    {
        $this->session->unset_userdata('selected_menu');
        $user = $this->session->userdata('user');

        $data = array(
            "title"     => "Delijeon - Success",
            "content"   => "carts/success"
        );

        $this->authorize($user, $data);
    }

    public function add_to_cart()
    {
        $is_success = false;
        $add_count = false;

        if ($this->form_validation->run('add_to_cart') === FALSE) {
            $result = validation_errors('<p class="error">', '</p>');
        } else {
            $form_data = $this->input->post(null, TRUE);
            $form_data['user_id'] = $this->session->userdata('user')['id'];

            if ($this->cart->is_product_exists($form_data)) {
                $this->cart->increment_product_quantity($form_data);
                $result = "Product updated in a cart";
            } else {
                $this->cart->add_to_cart($form_data);
                $result = "Product added in a cart";
                $add_count = true;
            }
            $is_success = true;
        }

        $output = array(
            'message'       => $result,
            'is_success'    => $is_success,
            'add_count'     => $add_count,
        );

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output));
    }

    public function remove_product()
    {
        $is_success = false;

        if ($this->form_validation->run('remove_cart') === FALSE) {
            $result = validation_errors();
        } else {

            $form_data = $this->input->post(null, TRUE);
            $form_data['user_id'] = $this->session->userdata('user')['id'];

            if ($this->cart->remove_from_cart($form_data)) {
                $result = "Product removed from the cart successfully";
                $is_success = true;
            } else {
                $result = "Someting went wrong while removing the product from the cart";
            }
        }

        $output = array(
            'message'       => $result,
            'is_success'    => $is_success,
        );

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output));
    }

    public function update_product_quantity()
    {
        $is_success = false;

        $form_data = $this->input->get();
        $form_data['user_id'] = $this->session->userdata('user')['id'];

        if ($this->cart->update_product_quantity($form_data)) {
            $is_success = true;
        }

        $output = array(
            'is_success'    => $is_success,
        );

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output));
    }

    private function authorize($user, $data)
    {
        if ($user) {
            if ($user['is_admin'] == 1) {
                redirect("dashboard/products");
            } else {
                $this->set_template($data);
            }
        } else {
            redirect("login");
        }
    }

    private function set_template($data)
    {
        if (isset($data['title'])) {
            $this->template->title = $data['title'];
        }
        if (isset($data['js'])) {
            if (is_array($data['js'])) {
                foreach ($data['js'] as $javascript) {
                    $this->template->javascript->add($javascript);
                }
            } else {

                $this->template->javascript->add($data['js']);
            }
        }

        if (is_array($data['content'])) {
            $this->template->content->view($data['content']['view'], $data['content']['data']);
        } else {
            $this->template->content->view($data['content']);
        }
        $this->template->publish();
    }
}
