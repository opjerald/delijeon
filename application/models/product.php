<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Model
{
    private $query = "";
    private $where = "";
    private $order_by = "";
    private $limit = "";
    private $values = array();

    public $img_path = 'assets/images/';

    public function get_all()
    {
        $select = "SELECT id, name, description, price, quantity, sold, images FROM products ";

        $products = $this->db->query($select . $this->query . $this->where . $this->order_by . $this->limit, $this->values)->result_array();
        foreach ($products as $key => $product) {
            $images = json_decode($product['images']);
            foreach ($images as $image) {
                if ($image->is_main == 1) {
                    $products[$key]['main_image'] = $image->file_name;
                }
            }
        }

        return $products;
    }

    public function name($name = "")
    {
        $this->and_where('name LIKE ?');
        $this->values[] = '%' . $this->security->xss_clean($name) . '%';
    }

    public function category($cat_id)
    {
        $this->and_where('category_id = ?');
        $this->values[] = $this->security->xss_clean($cat_id);
    }

    public function search($input)
    {
        if (!empty($input['name'])) {
            $this->name($input['name']);
        } else {
            $this->name('');
        }

        if (!empty($input['limit'])) {
            $this->limit = "LIMIT " . $input['limit'];
        }

        if (!empty($input['category'])) {
            $this->category($input['category']);
        }

        if (!empty($input['order'])) {
            $this->order_by_price($input['order']);
        } else {
            $this->order_by = "ORDER BY created_at DESC ";
        }
    }

    public function paginate($page = 1, $item_per_page = 15)
    {
        $offset = ($page - 1) * ($item_per_page);
        $total_count = $this->count_all();
        $this->limit = "LIMIT $item_per_page OFFSET $offset ";
        return ceil($total_count / $item_per_page);
    }

    public function get_by_id($id)
    {
        $query = "SELECT id, name, description, price, category_id, sold, images, quantity
                    FROM products 
                    WHERE id = ?
                    LIMIT 1";

        $values = array($this->security->xss_clean($id));

        $product = $this->db->query($query, $values)->row_array();
        $product['images'] = json_decode($product['images']);

        return $product;
    }

    public function update_quantities($items)
    {
        foreach ($items as $item) {
            $query = "UPDATE products SET quantity = ?, sold = ?, updated_at = NOW() WHERE id = ?";
            $values = array(
                $this->security->xss_clean(intval($item['product_quantity'] - $item['cart_quantity'])),
                $this->security->xss_clean(intval($item['sold'] + $item['cart_quantity'])),
                $this->security->xss_clean($item['product_id']),
            );

            $this->db->query($query, $values);
        }
    }

    private function count_all()
    {
        return $this->db->query("SELECT COUNT(*) as count FROM products " . $this->query . $this->where, $this->values)->row_array()['count'];
    }

    private function order_by_price($sort = "ASC")
    {
        $this->order_by .= "ORDER BY price ";
        $this->order_by .= $sort == 'DESC' ? 'DESC ' : 'ASC ';
    }

    private function and_where($query)
    {
        $this->where .= empty($this->where) ? 'WHERE ' : 'AND ';
        $this->where .= $query . ' ';
    }

    public function create($data)
    {
        $query = "INSERT INTO products (name, description, category_id, price, quantity, images, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $values = array(
            $this->security->xss_clean($data['name']),
            $this->security->xss_clean($data['description']),
            $this->security->xss_clean($data['category_id']),
            $this->security->xss_clean($data['price']),
            $this->security->xss_clean($data['quantity']),
            $this->security->xss_clean(json_encode($data['images'])),
        );

        return $this->db->query($query, $values);
    }

    public function delete($product_id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $values = array($this->security->xss_clean($product_id));
        return $this->db->query($query, $values);
    }
}
