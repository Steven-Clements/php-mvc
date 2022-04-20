<?php include APP_ROOT . '/views/includes/header.php'; ?>
<main id="verify-page">
  <div id="register-verify-banner"></div>
  <form id="verify-form" class="auth-form-40" action="<?php echo URL_ROOT; ?>/users/verify" method="POST">
    <div class="form-heading">
      <div class="form-logo"></div>
      <h1>Verify Your Email</h1>
    </div>
    <?php if ($data['user_email'] === '') : ?>
      <div class="input-group">
      <label for="email">Email Address</label>
      <input type="email" name="email" class="input-text" value="<?php echo $data['user_email']; ?>" />
      <?php echo $data['email_error']; ?>
      </div>
    <?php endif; ?>
    <div class="input-group">
      <label for="verification">Verification Code</label>
      <input type="password" name="verification" class="input-text" />
      <?php echo $data['verification_error']; ?>
    </div>
    <div class="button-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</main>
<?php include APP_ROOT . '/views/includes/footer.php'; ?>