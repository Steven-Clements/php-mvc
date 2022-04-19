<?php

/* ~ ~ ~ ~ ~ ${ Handle Internal Application Redirects } ~ ~ ~ ~ ~ */
function redirect($page)
{
  header('location: ' . URL_ROOT . '/' . $page);
}