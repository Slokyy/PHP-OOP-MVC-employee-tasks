<?php

  namespace Database;

  class Database
  {
    private static string $host = "localhost";
    private static string $user = "root";
    private static string $pwd = "";
    private static string $dbName = "backend_zaposleni";
    private static string $error;

    public static function connect(): \PDO | string
    {
      $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";";
      try {
        $pdo = new \PDO($dsn, self::$user, self::$pwd);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        return $pdo;
      } catch(\PDOException $e) {
        self::$error = $e->getMessage();
        return self::$error;
      }

    }
  }