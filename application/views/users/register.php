<?php include APP_ROOT . '/views/includes/header.php'; ?>
<main id="register-page">
  <div id="register-verify-banner"></div>
  <form id="register-form" class="auth-form-40" action="<?php echo URL_ROOT; ?>/users/register" method="POST">
    <div class="form-heading">
      <div class="form-logo"></div>
      <h1>Join Now!</h1>
    </div>
    <div class="input-group">
      <label for="name">Name</label>
      <input type="text" name="name" class="input-text" value="<?php echo $data['user_name']; ?>" />
      <?php echo $data['name_error']; ?>
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
    <div class="input-group">
      <label for="confirm">Confirm Password</label>
      <input type="password" name="confirm" class="input-text" />
      <?php echo $data['confirm_error']; ?>
    </div>
    <div class="input-group">
      <label for="name">Agree to Our <a href="<?php echo URL_ROOT; ?>/pages/terms" class="form-link">Site Terms</a></label>
      <input type="checkbox" name="agree" class="input-check" />
      <?php echo $data['agree_error']; ?>
    </div>
    <div class="button-group">
      <button type="submit" class="btn btn-primary">Register</button>
    </div>
    <p class="form-text">Already have an account? <a href="<?php echo URL_ROOT; ?>/users/login" class="form-link">Login Here!</a></p>
  </form>
</main>
<?php include APP_ROOT . '/views/includes/footer.php'; ?>