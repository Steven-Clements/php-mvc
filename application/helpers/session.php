<?php

/* ~ ~ ~ ~ ~ ${ Handle User Sessions } ~ ~ ~ ~ ~ */
session_start();

/* ~ ~ ~ ~ ~ ${ Handle Single-Use Flash Messages } ~ ~ ~ ~ ~ */
function flash($name = '', $message = '', $class = 'alert alert-success')
{
  if (!empty($name)) {
    if (!empty($message) && empty($_SESSION[$name])) {
      if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
      }

      if (!empty($_SESSION[$name . '_class'])) {
        unset($_SESSION[$name . '_class']);
      }

      $_SESSION[$name] = $message;
      $_SESSION[$name . '_class'] = $class;
    } elseif (empty($message) && !empty($_SESSION[$name])) {
      $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
      echo '<div class="alrt alrt-' . $class . '">' . $_SESSION[$name] . '</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}