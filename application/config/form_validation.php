<?php

$config = array(
    'signin' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    ),
    'signup' => array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|is_unique[users.email]',
            'errors' => [
                'is_unique' => 'Email is already taken.',
            ],
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[8]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]'
        ),
    ),
    'add_to_cart' => array(
        array(
            'field' => 'quantity',
            'label' => 'Quantiy',
            'rules' => 'trim|required|numeric|greater_than[0]'
        ),
        array(
            'field' => 'product_id',
            'label' => 'Product ID',
            'rules' => 'trim|required|numeric'
        )
    ),
    'remove_cart' => array(
        array(
            'field' => 'cart_id',
            'label' => 'Cart ID',
            'rules' => 'trim|required|numeric'
        )
    ),
    'update_cart' => array(
        array(
            'field' => 'product_id',
            'label' => 'Product ID',
            'rules' => 'trim|required|numeric'
        ),
        array(
            'field' => 'quantity',
            'label' => 'Quantity',
            'rules' => 'trim|required|numeric|greater_than[0]'
        )
    ),
);
