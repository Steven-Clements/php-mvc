<?php

class Database {
  /* ~ ~ ~ ~ ~ ${ Define Parameters } ~ ~ ~ ~ ~ */
  private $host = DB_HOST;
  private $db = DB_NAME;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbh;
  private $stmt;
  private $error;

  /* ~ ~ ~ ~ ~ ${ Write a Constructor Method } ~ ~ ~ ~ ~ */
  public function __construct() {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  /* ~ ~ ~ ~ ~ ${ Write a Prepared Statement (Query) } ~ ~ ~ ~ ~ */
  public function query($sql) {
    $this->stmt = $this->dbh->prepare($sql);
  }

  /* ~ ~ ~ ~ ~ ${ Bind Input Values Dynamically } ~ ~ ~ ~ ~ */
  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  /* ~ ~ ~ ~ ~ ${ Execute a Prepared Statement } ~ ~ ~ ~ ~ */
  public function execute() {
    return $this->stmt->execute();
  }

  /* ~ ~ ~ ~ ~ ${ Execute & Return All Results } ~ ~ ~ ~ ~ */
  public function resultSet() {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /* ~ ~ ~ ~ ~ ${ Execute & Return a Single Result } ~ ~ ~ ~ ~ */
  public function single() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  /* ~ ~ ~ ~ ~ ${ Determine Row Count of a Query } ~ ~ ~ ~ ~ */
  public function rowCount() {
    return $this->stmt->rowCount();
  }
}