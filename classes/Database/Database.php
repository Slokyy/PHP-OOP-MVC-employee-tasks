<?php

  namespace Database;

  class Database
  {
    private static string $host = "localhost";
    private static string $user = "root";
    private static string $pwd = "";
    private static string $dbName = "backend_zaposleni";
    private static string $error;
    private static \PDO $pdoObj;

    /**
     * get pdo connect object
     * @return \PDO
     */
    public static function connect(): \PDO
    {
      self::setPdo();
      return self::$pdoObj;
    }


    /**
     * Set pdo object
     * @return bool
     */
    private static function setPdo(): bool
    {
      $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";";
      try {
        $pdo = new \PDO($dsn, self::$user, self::$pwd);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        self::$pdoObj = $pdo;
        return true;
      } catch(\PDOException $e) {
        self::$error = $e->getMessage();
      }
      return false;
    }
  }