<div class="container">
    <h1 class="title"><a href="<?= base_url("login") ?>">Delijeon</a></h1>
    <form id="form-signup" action="<?= base_url('users/process_signup') ?>" method="post">
        <h2>Register</h2>
        <div class="messages">
            <?= $this->session->flashdata("msg") ?>
        </div>
        <label for="first_name">First Name:</label>
        <div class="input">
            <i class="bi bi-person"></i>
            <input type="text" name="first_name" id="first_name">
        </div>
        <label for="last_name">Last Name:</label>
        <div class="input">
            <i class="bi bi-person-fill"></i>
            <input type="text" name="last_name" id="last_name">
        </div>
        <label for="email">Email Address:</label>
        <div class="input">
            <i class="bi bi-at"></i>
            <input type="email" name="email" id="email">
        </div>
        <label for="password">Password:</label>
        <div class="input">
            <i class="bi bi-unlock"></i>
            <input type="password" name="password" id="password">
        </div>
        <label for="confirm_password">Confirm Password:</label>
        <div class="input">
            <i class="bi bi-unlock-fill"></i>
            <input type="password" name="confirm_password" id="confirm_password">
        </div>
        <a href="<?= base_url('login') ?>">Already have an account? Click here!</a>
        <input type="submit" value="Register">
    </form>
</div>