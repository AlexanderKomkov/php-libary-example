<?php

namespace App\Models;

use App\RMVC\Database\Connection;

use PDO;
use Exception;

abstract class Model
{
    /**
     * @var string
     */
    protected string $table = '';

    /**
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * @var array
     */
    protected array $fillable = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->pdo = Connection::make()->connect();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        if (empty($this->table))  {
            throw new Exception('Empty table name');
        }
    }

    /**
     * @param $data
     * @return array
     */
    protected function getAllowedData($data): array
    {
        $allowedData = [];
        foreach ($data as $key => $value) {
            if ($key == 'id' || in_array($key, $this->fillable)) $allowedData[$key] = $value;
        }
        return $allowedData;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return array|bool
     */
    public function all(): array|bool
    {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;
        
        return ($sth->execute()) ? $sth->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        $query = "SELECT * FROM $this->table WHERE id = ?";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return ($sth->execute([$id])) ? $sth->fetch(PDO::FETCH_ASSOC) : false;
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function create(array $data): false|string
    {
        $data = $this->getAllowedData($data);

        if (empty($data)) return false;

        $keys = [];
        $values = [];

        foreach ($data as $key => $value)
        {
            $keys[] = $key;
            $values[] = ':'. $key;
        }

        $query = "INSERT INTO $this->table  (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return ($sth->execute($data)) ? $this->pdo->lastInsertId() : false;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function update(array $data): bool
    {
        if (empty($data['id'])) throw new Exception('Empty key id on data');

        $data = $this->getAllowedData($data);

        if (empty($data)) return false;

        $sets = [];
        foreach ($data as $key => $value)
        {
            if ($key == 'id') continue;
            $sets[] = "$key=:$key";
        }

        $query = "UPDATE $this->table SET " . implode(', ', $sets) . " WHERE id=:id";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return $sth->execute($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool
    {
        $query = "DELETE FROM $this->table WHERE id = ?";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return $sth->execute([$id]);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string|null $exc_field
     * @param int|string|null $exc_value
     * @return bool
     */
    protected function isUnique(string $field, string $value, string $exc_field = null, int|string $exc_value = null): bool
    {
        $query = "SELECT $field FROM $this->table WHERE $field = ?";
        $data = [$value];

        if (!empty($exc_field) && !empty($exc_value))
        {
            $query .= " AND $exc_field <> ?";
            $data[] = $exc_value;
        }

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        $sth->execute($data);

        $result = $sth->fetch(PDO::FETCH_COLUMN);

        return empty($result);
    }

    /**
     * @param string $table
     * @param string $field_id
     * @param int $id
     * @param string $field_ids
     * @param array $ids
     * 
     * @return bool
     */
    protected function attach(string $table, string $field_id, int $id, string $field_ids, array $ids): bool 
    {
        $cols = [$field_id, $field_ids];
        $rows = [];
        foreach ($ids as $el_id) {
            $rows[] = [$id, (int) $el_id];
        }

        $row_length = count($rows[0]);
        $nb_rows = count($rows);
        $length = $nb_rows * $row_length;

        $args = implode(',', array_map(function($el) { 
                return '(' . implode(',', $el) . ')'; 
            }, array_chunk(array_fill(0, $length, '?'), $row_length)
        ));

        $data = [];
        foreach($rows as $row)
        {
            foreach($row as $value)
            {
                $data[] = $value;
            }
        }

        $query = "INSERT INTO $table (" . implode(', ', $cols) . ") VALUES " . $args;

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return $sth->execute($data);
    }

    /**
     * @param string $table
     * @param string $field_id
     * @param int $id
     * @param string|null $field_ids
     * @param array|null $ids
     * 
     * @return bool
     */
    protected function detach(string $table, string $field_id, int $id, string $field_ids = null, array $ids = null): bool 
    {
        if (!empty($field_ids) && !empty($ids))
        {
            $data = array_merge([$id], $ids);
            $in  = str_repeat('?,', count($ids) - 1) . '?';
            $query = "DELETE FROM $table WHERE $field_id = ? AND $field_ids IN ($in)";
        }
        else 
        {
            $data = [$id];
            $query = "DELETE FROM $table WHERE $field_id = ?";
        }

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return $sth->execute($data);
    }

    /**
     * @param string $table
     * @param string $field_id
     * @param int $id
     * @param string $field_ids
     * 
     * @return array
     */
    protected function getIds(string $table, string $field_id, int $id, string $field_ids): array
    {
        $query = "SELECT $field_ids from $table WHERE $field_id = ?";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return [];

        return ($sth->execute([$id])) ? $sth->fetchAll(PDO::FETCH_COLUMN) : [];
    }

    /**
     * @param string $table
     * 
     * @return array
     */
    protected function getTableRelations(string $table): array 
    {
        $query = "SELECT * from $table"; 

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return [];

        return ($sth->execute()) ? $sth->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    /**
     * @param string $table
     * @param string $field_id
     * @param int $id
     * @param string $field_ids
     * @param array $ids
     * 
     * @return bool
     */
    protected function sync(string $table, string $field_id, int $id, string $field_ids, array $ids): bool 
    {
        $exist_ids = $this->getIds($table, $field_id, $id, $field_ids);
        if ($exist_ids == $ids) return true;

        $datach_ids = [];
        foreach($exist_ids as $exist_id) {
            if (!in_array($exist_id, $ids)) $datach_ids[] = $exist_id;
        }
        
        if (!empty($datach_ids)) {
            if(!$this->detach($table, $field_id, $id, $field_ids, $datach_ids)) throw new Exception('Not detach table');
        }

        $attach_ids = [];
        foreach ($ids as $el_id) {
            if (!in_array($el_id, $exist_ids)) $attach_ids[] = $el_id;
        }

        if (!empty($attach_ids)) {
            if (!$this->attach($table, $field_id, $id, $field_ids, $attach_ids)) throw new Exception('Not attach table');
        }
 
        return true;
    }

    /**
     * @param string $table
     * @param array $ids
     * 
     * @return array
     */
    protected function hasMany(string $table, array $ids): array 
    {
        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $query = "SELECT * from $table WHERE id IN ($in)";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return [];

        return ($sth->execute($ids)) ? $sth->fetchAll(PDO::FETCH_ASSOC) : [];
    }

}