<?php

class Pages extends Controller {
  /* ~ ~ ~ ~ ~ ${ Write a Constructor Method } ~ ~ ~ ~ ~ */
  public function __construct() {
    $this->pageModel = $this->model('Page');
  }

  /* ~ ~ ~ ~ ~ ${ Create View for Home Page } ~ ~ ~ ~ ~ */
  public function index() {
    /* - - - - - < Make Data Available to Application /> - - - - - */
    $data = [
      'page_title' => APP_NAME . ' | Clementine Solutions',
      'page_description' => '',
      'page_keywords' => '',
      'page_url' => '/pages/index'
    ];

    /* - - - - - < Load the View & Pass in the Data /> - - - - - */
    $this->view($data['page_url'], $data);
  }
}