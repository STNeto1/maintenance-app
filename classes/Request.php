<?php

require_once "Database.php";

class Request
{

  private PDO $conn;

  public function __construct()
  {
    $this->conn = (new Database())->dbConnection();
  }

  public function insert(string $title, string $description): bool|PDOStatement
  {
    if (!$_SESSION['user_id']) {
      header('location: login.php?auth=1');
    }

    try {
      $stmt = $this->conn->prepare("INSERT INTO request (title, description, user_id) VALUES (:title, :description, :user_id)");
      $stmt->bindParam(":title", $title);
      $stmt->bindParam(":description", $description);
      $stmt->bindParam(":user_id", $_SESSION['user_id']);
      $stmt->execute();
      return $stmt;

    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function findAll(): array
  {
    try {
      $stmt = $this->conn->prepare("SELECT
                                              r.id as id,
                                              r.title as title,
                                              r.finished as finished,
                                              r.manager_id as manager,
                                              u.name as name,
                                              r.createdAt
                                          FROM request AS r
                                          LEFT JOIN USER AS u
                                          ON r.user_id = u.id;");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function findAllUserRequests(int $user_id): array
  {
    if (!$_SESSION['user_id']) {
      header('location: login.php?auth=1');
    }

    try {
      $stmt = $this->conn->prepare("SELECT
                                              r.id as id,
                                              r.title as title,
                                              r.finished as finished,
                                              r.user_id as user_id,
                                              r.manager_id as manager,
                                              u.name as name,
                                              u.role as role
                                          FROM request AS r
                                          LEFT JOIN USER AS u
                                          ON r.user_id = u.id
                                          WHERE r.user_id = :user_id;");
      $stmt->bindParam(":user_id", $_SESSION['user_id']);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }

  public function finishRequest(int $request_id): bool
  {
    if (!$_SESSION['user_id'] || !$_SESSION['role'] || $_SESSION['role'] != 1) {
      header('location: login.php?auth=1');
    }

    try {
      $stmt = $this->conn->prepare("UPDATE request SET finished = 1 WHERE id = :id");
      $stmt->bindParam(":id", $request_id);
      $stmt->execute();
      return true;
    } catch (PDOException $exception) {
      die($exception->getMessage());
    }
  }
}