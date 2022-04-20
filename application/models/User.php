<?php

use Symfony\Component\Uid\UuidV4;

class User {
  /* ~ ~ ~ ~ ~ ${ Write a Constructor Method } ~ ~ ~ ~ ~ */
  public function __construct() {
    $this->db = new Database;
    $this->id = new UuidV4();
  }

  /* ~ ~ ~ ~ ~ ${ Generate a Random Verification Code } ~ ~ ~ ~ ~ */
  private function generateRandomVerificationCode() {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*+?';
    $index1 = mt_rand(0, 71);
    $index2 = mt_rand(0, 71);
    $index3 = mt_rand(0, 71);
    $index4 = mt_rand(0, 71);
    $index5 = mt_rand(0, 71);
    $index6 = mt_rand(0, 71);
    $index7 = mt_rand(0, 71);

    $char1 = $chars[$index1];
    $char2 = $chars[$index2];
    $char3 = $chars[$index3];
    $char4 = $chars[$index4];
    $char5 = $chars[$index5];
    $char6 = $chars[$index6];
    $char7 = $chars[$index7];

    $code = $char7 . $char2 . $char5 . $char4 . $char3 . $char6 . $char1;

    return $code;
  }

  /* ~ ~ ~ ~ ~ ${ Find a User By Email } ~ ~ ~ ~ ~ */
  public function findUserByEmail($email) {
    $this->db->query('SELECT * FROM Users WHERE email = :email');

    $this->db->bind(':email', $email);

    $this->db->execute();

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* ~ ~ ~ ~ ~ ${ Create & Send User a Verification Code } ~ ~ ~ ~ ~ */
  public function createSendVerificationCode($email) {
    $code = $this->generateRandomVerificationCode();

    if (sendVerificationEmail($email, $code)) {
      $code = password_hash($code, PASSWORD_BCRYPT);

      return $code;
    } else {
      return false;
    }
  }

  /* ~ ~ ~ ~ ~ ${ Register a New User } ~ ~ ~ ~ ~ */
  public function registerNewUser($data) {
    $this->db->query('INSERT INTO Users (id, name, email, password, verification) VALUES (:id, :name, :email, :password, :verification)');

    $this->db->bind(':id', $this->id);
    $this->db->bind(':name', $data['user_name']);
    $this->db->bind(':email', $data['user_email']);
    $this->db->bind(':password', $data['user_password']);
    $this->db->bind(':verification', $data['user_verification']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}