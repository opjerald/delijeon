<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe extends CI_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("cart");
        $this->load->model("order");
        $this->load->model("product");
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function pay()
    {
        $user = $this->session->userdata("user");
        $input = $this->input->post(null, TRUE);

        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        \Stripe\Charge::create([
            "amount" => $this->cart->total_price($user['id']),
            "currency" => "usd",
            "source" => $this->input->post('stripeToken'),
            "description" => "Just a test payment."
        ]);

        $this->session->set_flashdata('success', 'Payment made successfully.');

        $shipping = array(
            "first_name"    => $input['first_name_ship'],
            "last_name"     => $input['last_name_ship'],
            "address"       => $input['address_ship'],
            "postal_code"   => $input['postal_code_ship'],
            "city"          => $input['city_ship'],
            "region"        => $input['region_ship'],
            "country"       => $input['country_ship'],
        );

        $billing = array(
            "first_name"    => $input['first_name_bill'],
            "last_name"     => $input['last_name_bill'],
            "address"       => $input['address_bill'],
            "postal_code"   => $input['postal_code_bill'],
            "city"          => $input['city_bill'],
            "region"        => $input['region_bill'],
            "country"       => $input['country_bill'],
            "card"          => $input['card'],
            "code"          => $input['code'],
            "month"         => $input['month'],
            "year"          => $input['year'],
            "total_payment" => $this->cart->total_price($user['id']) + 50,
        );

        $data['stripe_key'] = $input['stripeToken'];
        $data['shipping'] = $shipping;
        $data['billing'] = $billing;

        $cart_items = $this->cart->get_all($user['id']);
        $order_id = $this->order->create_order($data);

        $this->order->add_order_items($order_id, $cart_items);
        $this->product->update_quantities($cart_items);

        $this->cart->reset_cart($user['id']);

        redirect('carts/order_success');
    }
}
