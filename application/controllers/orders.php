<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order');
        $this->load->model('cart');
        $this->load->model('product');
    }

    public function admin_orders()
    {
        $user = $this->session->userdata("user");
        $data = array(
            "title"     => "Delijeon - Dashboard Orders",
            "js"        => "assets/js/admin/orders.js",
            "content"   => 'dashboard/orders'
        );

        $this->authorize($user, $data);
    }

    public function order($id)
    {
        $user = $this->session->userdata("user");
        $param['order_id'] = $id;

        $data = array(
            "title"     => "Delijeon - Dashboard Orders",
            "content"   => array(
                "view" => 'dashboard/order',
                "data" => array(
                    "order" => $this->order->get_by_id($param)
                ),
            ),
        );

        $this->authorize($user, $data);
    }

    public function index_html()
    {
        $page = $this->input->get("page") ?? 1;
        $input = $this->input->get();

        $this->order->search($input);
        $link_count = $this->order->paginate($page, 3);
        $orders = $this->order->get_all();

        $data = array(
            "orders"        => $orders,
            "link_count"    => $link_count,
            "page"          => $page
        );

        $this->load->view('partials/admin/orders', $data);
    }

    public function ajax_update($id)
    {
        $is_success = false;

        $data['status'] = $this->input->post('status');
        $data['order_id'] = $id;

        if ($this->order->update_status($data)) {
            $is_success = true;
            $result = "Order status updated";
        } else {
            $result = "Something wrong when updating order status";
        }

        $output = array(
            "message"       => $result,
            "is_success"    => $is_success
        );

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output));
    }

    private function authorize($user, $data)
    {
        if ($user) {
            if ($user['is_admin'] == 1) {
                $this->set_template($data);
            } else {
                redirect("home");
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
            $this->template->javascript->add($data['js']);
        }
        if (is_array($data['content'])) {
            $this->template->content->view($data['content']['view'], $data['content']['data']);
        } else {
            $this->template->content->view($data['content']);
        }
        $this->template->publish('index');
    }
}
