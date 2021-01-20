<?php

require_once "Database.php";

class User
{
  private PDO $conn;

  public function __construct()
  {
    $this->conn = (new Database())->dbConnection();
  }

  public function insert(string $name, string $username, string $password): array
  {
    $passwd = password_hash($password, PASSWORD_DEFAULT);
    $role = 2;

    // 1 - manager
    // 2 - normal user

    try {
      $stmt = $this->conn->prepare("INSERT INTO user (name, username, password, role) VALUES (:name, :username, :password, :role)");
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $passwd);
      $stmt->bindParam(":role", $role);
      $stmt->execute();
      return self::findUserByUsername($username);

    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function selectAll(): array
  {
    try {
      $stmt = $this->conn->prepare("SELECT id, username, name, role FROM users");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function findUserById(int $id)
  {
    try {
      $stmt = $this->conn->prepare("SELECT id, username, name, role FROM user WHERE id = :id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function findUserByUsername(string $username): array
  {
    try {
      $stmt = $this->conn->prepare("SELECT id, username, name, role FROM user WHERE username = :username");
      $stmt->bindParam(":username", $username);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function findUsersByName(string $name): array
  {
    try {
      $search = "%$name%";
      $stmt = $this->conn->prepare("SELECT id, username, name, role FROM user WHERE name LIKE ?");
      $stmt->execute([$search]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }


  public function deleteUser(int $id): bool
  {
    try {
      $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }


}