<?php

namespace App\RMVC\Database;

use Exception;
use PDO;

final class Connection
{
    /**
     * @var Connection|null
     */
    private static ?Connection $conn = null;

    /**
     * @throws Exception
     * @return PDO
     */
    public function connect(): PDO
    {
        $params = parse_ini_file('../config/database.ini');
        if ($params === false) {
            throw new Exception("Error reading database configuration file");
        }

        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $params['host'],
            $params['port'],
            $params['database'],
            $params['user'],
            $params['password']
        );

        $pdo = new PDO($conStr);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * @return Connection
     */
    public static function make(): Connection
    {
        if (null === self::$conn) {
            self::$conn = new self();
        }

        return self::$conn;
    }

    protected function __construct()
    {

    }
}