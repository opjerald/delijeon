<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product');
        $this->load->model('category');
    }

    public function index()
    {
        $this->session->set_userdata("selected_menu", array("menu" => "Home", "hero" => "Home"));
        $user = $this->session->userdata("user");

        $data = array(
            "title"     => "Delijeon - Home",
            "content"   => "products/index"
        );

        $this->authorize($user, $data);
    }

    public function product($id)
    {
        $this->session->set_userdata("selected_menu", array("menu" => "Shop", "hero" => "Product"));
        $product = $this->product->get_by_id($id);
        $user = $this->session->userdata("user");

        $data = array(
            "title" => $product['name'],
            "js"    => "assets/js/user/product.js",
            "content" => array(
                "view" => "products/product",
                "data" => array(
                    "product" => $product
                )
            )
        );

        $this->authorize($user, $data);
    }

    public function shop()
    {
        $this->session->set_userdata("selected_menu", array("menu" => "Shop", "hero" => "Shop"));
        $user = $this->session->userdata("user");

        $data = array(
            "title" => "Delijeon - Shop",
            "js" => "assets/js/user/products.js",
            "content"   => array(
                'view'  => "products/shop",
                'data'  => array(
                    'categories'    => $this->category->get_all_with_count(),
                )
            )
        );

        $this->authorize($user, $data);
    }

    public function admin_products()
    {
        $data = array(
            "title"     => "Delijeon - Dashboard Products",
            "js"        => "assets/js/admin/products.js",
            "content"   => array(
                "view" => 'dashboard/products',
                "data" => array(
                    "categories" => $this->category->get_all(),
                )
            )
        );
        $this->set_template($data);
    }

    public function save()
    {
        if (!empty($this->input->post('product_id'))) {
            $this->update_product();
        } else {
            $this->create_product();
        }

        redirect("dashboard/products");
    }

    public function delete($id)
    {
        $this->product->delete($id);
        redirect("dashboard/products");
    }

    private function update_product()
    {
    }

    private function create_product()
    {

        $input_data = $this->input->post(NULL, TRUE);


        $input_data['images'] = $this->upload_images($_FILES, $input_data['main']);
        if (!empty($data['new_category'])) {
            $id = $this->category->create($input_data['new_category']);
            $input_data['category_id'] = $id;
        }
        $this->product->create($input_data);
    }


    private function upload_images($files, $main)
    {
        $data = [];
        $count = count($files['files']['name']);

        for ($i = 0; $i < $count; $i++) {
            if (!empty($files['files']['name'][$i])) {
                $_FILES['image']['name']     = $files['files']['name'][$i];
                $_FILES['image']['type']     = $files['files']['type'][$i];
                $_FILES['image']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['image']['error']    = $files['files']['error'][$i];
                $_FILES['image']['size']     = $files['files']['size'][$i];

                $config['upload_path'] =  "./assets/images/";
                $config['allowed_types'] = 'gif|jpg|png|webp';
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $image['file_name'] = $upload_data['file_name'];
                    $image['is_main'] = $main == $image['file_name'] ? 1 : 0;
                    $data[] = $image;
                }
            }
        }

        return !empty($data) ? $data : array('file_name' => "default.jpg", "is_main" => 1);
    }

    public function index_html()
    {
        $user = $this->session->userdata("user");
        $page = $this->input->get("page") ?? 1;
        $item_per_page = $this->input->get('item_per_page') ?? 3;

        $input = $this->input->get();
        $this->product->search($input);

        $link_count = $this->product->paginate($page, $item_per_page);
        $products = $this->product->get_all();

        $data = array(
            'products'      => $products,
            'link_count'    => $link_count,
            'page'          => $page
        );

        if ($user['is_admin'] == 1) {
            $this->load->view('partials/admin/products', $data);
        } else {
            $this->load->view('partials/users/products', $data);
        }
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
