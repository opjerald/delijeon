<?php

class Category extends CI_Model
{

    public function get_all()
    {
        $query = "SELECT id, name FROM categories";
        return $this->db->query($query)->result_array();
    }

    public function get_all_with_count()
    {
        $query = "SELECT categories.id, categories.name, COUNT(*) as total_product 
                    FROM categories 
                    INNER JOIN products ON products.category_id = categories.id
                    GROUP BY categories.id";
        return $this->db->query($query)->result_array();
    }

    public function create($name)
    {
        $query = "INSERT INTO categories (name, created_at) VALUES (?, NOW())";
        $this->db->query($query, $this->security->xss_clean($name));

        return $this->db->insert_id();
    }

    public function delete($id)
    {
        $query = "DELETE FROM categories WHERE id = ?";
        $values = array($this->security->xss_clean($id));
        return $this->db->query($query, $values);
    }

    public function update($input)
    {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $values = array(
            $this->security->xss_clean($input['category_name']),
            $this->security->xss_clean($input['category_id'])
        );
        return $this->db->query($query, $values);
    }
}
