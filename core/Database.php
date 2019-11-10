<?php

class Database {
  private static $_instance = null;
  private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

  private function __construct() {
    try {
      ini_set("display_errors", 1);
      $this->_pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', SQL_UNAME, PASS);
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public function errors() {
    return ($this->_pdo->errorInfo());
  }

  public static function getInstance() {
    if (!isset(self::$_instance)) {
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

  public function query($sql, $params = [], $insert = false) {
    $this->_error = False;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if (count($params)) {
        foreach($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      if ($this->_query->execute()) {
            if (strstr($sql, 'DELETE'))
              return ($this);
            if (!$insert) {
              $this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
              $this->_count = $this->_query->rowCount();
              $this->_lastInsertID = $this->_pdo->lastInsertId();
            }
      } else {
        $this->_error = true;
      }
    }
    return ($this);
  }

  public function insert($table, $fields = []) {
    $fieldString = '';
    $valueString = '';
    $values = [];

    foreach($fields as $field => $value) {
      $fieldString .= '`' . $field . '`,';
      $valueString .= '?,';
      $values[] = $value;
    }
    $fieldString = rtrim($fieldString, ',');
    $valueString = rtrim($valueString, ',');
    $sql = "INSERT INTO `{$table}` ({$fieldString}) VALUES ({$valueString})";
    if (!$this->query($sql, $values, true)->error()) {
      return True;
    }
    return false;
  }

  public function update($table, $id, $fields = []) {
    $fieldString = '';
    $values = [];
    foreach($fields as $field => $value) {
      $fieldString .= ' `' . $field . '` = ' . '?,';
      $values[] = $value;
    }
    $fieldString = trim($fieldString);
    $fieldString = rtrim($fieldString, ',');
    $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
    if (!$this->query($sql, $values, true)->error()) {
      return (true);
    }
    return (false);
  }

  public function delete($table, $id) {
    $sql = "DELETE FROM {$table} WHERE id = {$id}";
    if (!$this->query($sql)->error()) {
      return (true);
    }
    return (false);
  }

  protected function _read($table, $params = []) {
    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';

    // set up conditions
    if (isset($params['conditions'])) {
      if (is_array($params['conditions'])) {
        foreach($params['conditions'] as $condition) {
          $conditionString .= $condition . ' AND ';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, ' AND');
        $conditionString = ' WHERE ' . $conditionString;
      } else {
        $conditionString .= ' WHERE ' . $conditionString;
        $conditionString .= $params['conditions'];
      }
    }

    // binding
    if (array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }

    // order
    if (array_key_exists('order', $params)) {
      $order = ' ORDER BY ' . $params['order'];
    }

    // limit
    if (array_key_exists('limit', $params)) {
      $limit = ' LIMIT ' . $params['limit'];
    }

    $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
    if ($this->query($sql, $bind)) {
      if (count($this->_result)) {
        return false;
      }
      return true;
    }
    return false;
  }

  public function find($table, $params = []) {
    if (!$this->_read($table, $params)) {
      return ($this->results());
    }
    return (false);
  }

  public function findFirst($table, $params = []) {
    if (!$this->_read($table, $params)) {
      return ($this->first());
    }
    return (false);
  }

  public function results() {
    return ($this->_result);
  }

  public function first() {
    return ((!empty($this->_result)) ? $this->_result[0]: []);
  }

  public function count() {
    return ($this->_count);
  }

  public function lastID() {
    return ($this->lastInsertID);
  }

  public function get_columns($table) {
    return ($this->query("SHOW COLUMNS FROM {$table}")->results());
  }

  public function makeUseOf() {
    return ($this->_result);
  }

  public function error() {
    return $this->_error;
  }
}
