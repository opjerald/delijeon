<?php

class Order extends CI_Model
{
    private $query = "";
    private $where = "";
    private $limit = "";
    private $values = array();

    public function get_all()
    {
        $select = "SELECT orders.id,
                        CONCAT(JSON_UNQUOTE(JSON_EXTRACT(billing, '$.first_name')),' ',JSON_UNQUOTE(JSON_EXTRACT(billing, '$.last_name'))) AS name,
                        DATE_FORMAT(orders.created_at, '%m/%d/%Y') AS date,
                        JSON_UNQUOTE(JSON_EXTRACT(billing, '$.address')) AS address,
                        JSON_UNQUOTE(JSON_EXTRACT(billing, '$.total_payment')) AS total,
                        orders.status
                    FROM orders 
                    INNER JOIN order_items ON orders.id = order_items.order_id ";
        return $this->db->query($select . $this->query . $this->where . "GROUP BY orders.id ORDER BY orders.created_at DESC " . $this->limit, $this->values)->result_array();
    }

    public function search($data)
    {
        if (!empty($data['search'])) {
            $this->name($data['search']);
        }

        if (!empty($data['search'] && is_numeric($data['search']))) {
            $this->order_id($data['search']);
        }

        if (!empty($data['status']) && $data['status'] != '') {
            $this->status($data['status']);
        }
    }

    public function name($name = "")
    {
        $this->or_where("( JSON_UNQUOTE(JSON_EXTRACT(billing, '$.first_name')) LIKE ? OR JSON_UNQUOTE(JSON_EXTRACT(billing, '$.last_name')) LIKE ?) ");
        $this->values[] = '%' . $this->security->xss_clean($name) . '%';
        $this->values[] = '%' . $this->security->xss_clean($name) . '%';
    }

    public function order_id($order_id)
    {
        $this->or_where('orders.id = ?');
        $this->values[] = $this->security->xss_clean($order_id);
    }

    public function status($status)
    {
        $this->and_where('orders.status = ? ');
        $this->values[] = $this->security->xss_clean($status);
    }

    public function paginate($page = 1, $item_per_page = 15)
    {
        $offset = ($page - 1) * ($item_per_page);
        $total_count = $this->count_all();
        $this->limit = "LIMIT $item_per_page OFFSET $offset ";
        return ceil($total_count / $item_per_page);
    }

    private function count_all()
    {
        $select = "SELECT DISTINCT COUNT(*) OVER() as count FROM orders 
                INNER JOIN order_items ON orders.id = order_items.order_id ";

        return $this->db->query($select . $this->query . $this->where . 'GROUP BY orders.id ', $this->values)->row_array()['count'] ?? 0;
    }

    public function get_items_by_id($data)
    {
        $query = "SELECT id, product_name, price, quantity, (price * quantity) AS total
                    FROM order_items
                    WHERE order_id = ?";
        $values = array($this->security->xss_clean($data['order_id']));
        return $this->db->query($query, $values)->result_array();
    }

    public function get_by_id($data)
    {
        $query = "SELECT * FROM orders WHERE id = ?";
        $values = array($this->security->xss_clean($data['order_id']));

        $order = $this->db->query($query, $values)->row_array();

        $order['shipping'] = json_decode($order['shipping']);
        $order['billing'] = json_decode($order['billing']);

        $order['items'] = $this->get_items_by_id($data);

        return $order;
    }

    public function create_order($data)
    {
        $query = "INSERT INTO orders (stripe_key, status, shipping, billing, created_at)
                    VALUES (?, 'Order in Process', ?, ?, NOW())";
        $values = array(
            $this->security->xss_clean($data['stripe_key']),
            $this->security->xss_clean(json_encode($data['shipping'])),
            $this->security->xss_clean(json_encode($data['billing'])),
        );
        $this->db->query($query, $values);
        return $this->db->insert_id();
    }

    public function add_order_items($order_id, $items)
    {
        foreach ($items as $item) {
            $query = "INSERT INTO order_items (order_id, product_name, price, quantity, created_at)
                        VALUES (?, ?, ?, ?, NOW())";
            $values = array(
                $this->security->xss_clean($order_id),
                $this->security->xss_clean($item['name']),
                $this->security->xss_clean($item['price']),
                $this->security->xss_clean($item['cart_quantity']),
            );
            $this->db->query($query, $values);
        }
    }

    public function update_status($data)
    {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $values = array(
            $this->security->xss_clean($data['status']),
            $this->security->xss_clean($data['order_id']),
        );

        return $this->db->query($query, $values);
    }

    private function and_where($query)
    {
        $this->where .= empty($this->where) ? 'WHERE ' : 'AND ';
        $this->where .= $query . ' ';
    }

    private function or_where($query)
    {
        $this->where .= empty($this->where) ? 'WHERE ' : 'OR ';
        $this->where .= $query . ' ';
    }
}
