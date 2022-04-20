<?php include APP_ROOT . '/views/includes/header.php'; ?>
<main id="login-page">
  <div id="login-banner"></div>
  <form id="login-form" class="auth-form-40" action="<?php echo URL_ROOT; ?>/users/login" method="POST">
    <div class="form-heading">
      <div class="form-logo"></div>
      <h1>Member Login</h1>
    </div>
    <div class="input-group">
    <label for="email">Email Address</label>
    <input type="email" name="email" class="input-text" value="<?php echo $data['user_email']; ?>" />
    <?php echo $data['email_error']; ?>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="input-text" />
      <?php echo $data['password_error']; ?>
    </div>
    <div class="button-group">
      <button type="submit" class="btn btn-primary">Login</button>
      <a href="" class="btn btn-secondary">Forgot Password</a>
    </div>
    <p class="form-text">Don't have an account? <a href="<?php echo URL_ROOT; ?>/users/register" class="form-link">Register Here!</a></p>
  </form>
</main>
<?php include APP_ROOT . '/views/includes/footer.php'; ?>