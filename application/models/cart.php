<?php

class Cart extends CI_Model
{
    public function get_all($user_id)
    {
        $query = "SELECT carts.id,carts.product_id, products.name, carts.quantity AS cart_quantity, products.price, products.quantity AS product_quantity, products.sold, products.images  
                    FROM carts 
                    INNER JOIN products ON carts.product_id = products.id 
                    WHERE user_id = ?";
        $values = array($this->security->xss_clean($user_id));

        $products =  $this->db->query($query, $values)->result_array();

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

    public function total_price($user_id)
    {
        $query = "SELECT SUM(carts.quantity*products.price) AS total
                    FROM carts INNER JOIN products ON carts.product_id = products.id
                    WHERE user_id = ?";
        $values = array($this->security->xss_clean($user_id));

        return $this->db->query($query, $values)->row_array()['total'];
    }

    public function add_to_cart($data)
    {
        $query = "INSERT INTO carts (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())";
        $values = array(
            $this->security->xss_clean($data['user_id']),
            $this->security->xss_clean($data['product_id']),
            $this->security->xss_clean($data['quantity']),
        );

        return $this->db->query($query, $values);
    }

    public function is_product_exists($data)
    {
        $query = "SELECT id FROM carts WHERE user_id = ? AND product_id = ?";
        $values = array(
            $this->security->xss_clean($data['user_id']),
            $this->security->xss_clean($data['product_id'])
        );

        return $this->db->query($query, $values)->row_array();
    }

    public function increment_product_quantity($data)
    {
        $query = 'UPDATE carts SET quantity = quantity + ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?';
        $values = array(
            $this->security->xss_clean($data['quantity']),
            $this->security->xss_clean($data['user_id']),
            $this->security->xss_clean($data['product_id']),
        );

        return $this->db->query($query, $values);
    }

    public function update_product_quantity($data)
    {
        $query = 'UPDATE carts SET quantity = ?, updated_at = NOW() WHERE user_id = ? AND id = ?';
        $values = array(
            $this->security->xss_clean($data['quantity']),
            $this->security->xss_clean($data['user_id']),
            $this->security->xss_clean($data['cart_id']),
        );

        return $this->db->query($query, $values);
    }

    public function remove_from_cart($data)
    {
        $query = "DELETE FROM carts WHERE id = ? AND user_id = ?";
        $values = array(
            $this->security->xss_clean($data['cart_id']),
            $this->security->xss_clean($data['user_id']),
        );

        return $this->db->query($query, $values);
    }

    public function cart_count($user_id)
    {
        $query = "SELECT COUNT(*) AS cart_count FROM carts WHERE user_id = ?";
        $values = array($this->security->xss_clean($user_id));

        return $this->db->query($query, $values)->row_array()['cart_count'];
    }

    public function reset_cart($user_id)
    {
        $query = "DELETE FROM carts WHERE user_id = ?";
        $values = array($this->security->xss_clean($user_id));

        return $this->db->query($query, $values);
    }
}
