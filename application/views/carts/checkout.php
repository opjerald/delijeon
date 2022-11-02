<section class="checkout">
    <div class="left">
        <header>
            <h1>Delijeon</h1>
            <ul class="breadcrumb">
                <li><a href="<?= base_url('cart') ?>">Cart</a><i class="bi bi-chevron-right"></i></li>
                <li><a href="#" class="selected">Payment</a></li>
            </ul>
        </header>
        <section class="contact-info">
            <big>Contact Information</big>
            <div class="table">
                <div class="row">
                    <p class="rowhead">Contact</p>
                    <p class="cell flex-1"><?= $email ?></p>
                </div>
            </div>
        </section>
        <form id="payment-form" class="form-validation" data-cc-on-file="false" action="<?= base_url('stripe-pay') ?>" method="post" data-stripe-publishable-key="<?= $this->config->item("stripe_key") ?>">
            <div class="shipping">
                <main class="method">
                    <div class="header">
                        <big>Shipping Address</big>
                    </div>
                    <div class="inputs">
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="first_name_ship" id='first_name_ship' required />
                            <label for="first_name" class="form__label">First Name</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="last_name_ship" id='last_name_ship' required />
                            <label for="last_name" class="form__label">Last Name</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="address_ship" id='address_ship' required />
                            <label for="address" class="form__label">Address</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="postal_code_ship" id='postal_code_ship' required />
                            <label for="postal_code" class="form__label">Postal Code</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="city_ship" id='city_ship' required />
                            <label for="city" class="form__label">City</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="region_ship" id='region_ship' required />
                            <label for="region" class="form__label">Region</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="country_ship" id='country_ship' required />
                            <label for="country" class="form__label">Country</label>
                        </div>
                    </div>
                </main>
            </div>
            <div class="payment">
                <div class="method">
                    <div class="header">
                        <big>Billing Address</big>
                        <small>Select the address that matches your card or payment method.</small>
                    </div>
                    <div class="options">
                        <label class="rd-same-billing"><input type="radio" name="option" value="same"> Same as shipping address</label>
                        <label class="rd-other-billing"><input type="radio" name="option" value="other" checked> Use different billing address</label>
                    </div>
                    <div class="inputs">
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="first_name_bill" id='first_name_bill' required />
                            <label for="first_name_bill" class="form__label">First Name</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="last_name_bill" id='last_name_bill' required />
                            <label for="last_name_bill" class="form__label">Last Name</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="address_bill" id='address_bill' required />
                            <label for="address_bill" class="form__label">Address</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="postal_code_bill" id='postal_code_bill' required />
                            <label for="postal_code_bill" class="form__label">Postal Code</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="city_bill" id='city_bill' required />
                            <label for="city_bill" class="form__label">City</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="region_bill" id='region_bill' required />
                            <label for="region_bill" class="form__label">Region</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field" placeholder="something" name="country_bill" id='country_bill' required />
                            <label for="country_bill" class="form__label">Country</label>
                        </div>
                    </div>
                </div>
                <div class="method">
                    <div class="header">
                        <big>Payment</big>
                        <small>All transactions are secure and encrypted.</small>
                    </div>
                    <div class="inputs">
                        <div class="form__group input">
                            <input type="text" class="form__field form-control card-number" placeholder="something" name="card" id='card' autocomplete="off" />
                            <label for="card" class="form__label">Card</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field form_control card-cvc" placeholder="something" name="code" id='code' autocomplete="off" />
                            <label for="code" class="form__label">Security Code</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field form-control card-expiry-month" placeholder="something" name="month" id='month' autocomplete="off" />
                            <label for="month" class="form__label">Month</label>
                        </div>
                        <div class="form__group input">
                            <input type="text" class="form__field form-control card-expiry-year" placeholder="something" name="year" id='year' autocomplete="off" />
                            <label for="year" class="form__label">Year</label>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <a href="<?= base_url('cart') ?>"><i class="bi bi-chevron-left"></i> Return to Cart</a>
                <button id="btn-pay" type="submit">Place Order</button>
            </footer>
        </form>
    </div>
    <div class="right">
        <div class="products">
            <?php foreach ($products as $product) { ?>
                <div class="product">
                    <div class="image">
                        <img src="<?= base_url("assets/images/{$product['main_image']}") ?>" alt="<?= $product['main_image'] ?>">
                        <p><?= $product['cart_quantity'] ?></p>
                    </div>
                    <p class="name"><?= $product['name'] ?></p>
                    <p class="price">P<?= $product['price'] ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="initial-price">
            <div>
                <small>Subtotal:</small>
                <p class="price">P<?= $total_price ?></p>
            </div>
            <div>
                <small>Shipping:</small>
                <p class="price">P50</p>
            </div>
        </div>
        <div class="total">
            <div>
                <small>Total:</small>
                <p class="price">P<?= $total_price + 50 ?></p>
            </div>
        </div>
    </div>
</section>