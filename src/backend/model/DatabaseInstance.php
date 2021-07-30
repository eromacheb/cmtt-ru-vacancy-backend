<?php

namespace model;

class DatabaseInstance
{
    protected $db;
    protected $config;

    public static $instance;

    public static function Instance($config = '')
    {
        $class = get_called_class();
        if ($class::$instance == null) {
            $class::$instance = new $class($config);
        }

        return $class::$instance;
    }

    function __construct($config)
    {
        $this->config = $config;

        $this->db = new \MeekroDB(
            $this->config['DB']['host'],
            $this->config['DB']['login'],
            $this->config['DB']['pass'],
            $this->config['DB']['database'],
            $this->config['DB']['port'],
            'utf8'
        );
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->db, $name], $arguments);
    }

    public function get($model)
    {
        $model = "\model\\" . $model;
        $class = new $model($this->db, $this->config);

        return $class;
    }

    public function create(string $table, array $data): int
    {
        $this->db->insert($table, $data);
        return $this->db->insertId();
    }

    public function update(string $table, array $data): bool
    {
        return $this->db->update($table, $data, "id=%i", $data['id']);
    }

}
