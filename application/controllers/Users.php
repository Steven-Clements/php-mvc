<?php

class Users extends Controller {
  /* ~ ~ ~ ~ ~ ${ Write a Constructor Method } ~ ~ ~ ~ ~ */
  public function __construct() {
    $this->userModel = $this->model('User');
  }

  /* ~ ~ ~ ~ ~ ${ Create Redirect Method for User Index } ~ ~ ~ ~ ~ */
  public function index() {
    redirect('users/login');
  }

  /* ~ ~ ~ ~ ~ ${ Create View for Register Page } ~ ~ ~ ~ ~ */
  public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      /* - - - - - < Filter & Sanitize User Input /> - - - - - */
      $_POST = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Join Now | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/register'
      ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Join Now | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/register'
      ];

      /* - - - - - < Load the View & Pass in the Data /> - - - - - */
      $this->view($data['page_url'], $data);
    }
  }
}