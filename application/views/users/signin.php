<div class="container">
    <h1 class="title"><a href="<?= base_url("login") ?>">Delijeon</a></h1>
    <form id="form-signin" action="<?= base_url('users/process_signin') ?>" method="post">
        <h2>Login</h2>
        <div class="messages">
            <?= $this->session->flashdata("msg") ?>
        </div>
        <label for="email">Email Address:</label>
        <div class="input">
            <i class="bi bi-at"></i>
            <input type="email" name="email" id="email">
        </div>
        <label for="password">Password:</label>
        <div class="input">
            <i class="bi bi-unlock-fill"></i>
            <input type="password" name="password" id="password">
        </div>
        <a href="<?= base_url('register') ?>">Don't have an account? Click here!</a>
        <input type="submit" value="Login">
    </form>
</div>