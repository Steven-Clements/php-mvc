<?php

require_once 'configuration/config.php';

require_once 'helpers/email.php';
require_once 'helpers/redirect.php';
require_once 'helpers/session.php';

require '../vendor/autoload.php';

spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});