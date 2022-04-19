<?php

class Controller {
  /* ~ ~ ~ ~ ~ ${ Load Application Models } ~ ~ ~ ~ ~ */
  public function model($model) {
    require_once '../application/models/' . $model . '.php';
    return new $model;
  }

  /* ~ ~ ~ ~ ~ ${ Load Application Views } ~ ~ ~ ~ ~ */
  public function view($view, $data = []) {
    require_once '../application/views/' . $view . '.php';
  }
}