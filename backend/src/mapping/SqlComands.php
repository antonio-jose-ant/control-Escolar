<?php
namespace App\mapping;
class SqlComands
{
    public static function insert(string $table, array $columns)
    {
        $cols = implode(',', $columns);
        $values = implode(
            ',',
            array_map(
                fn($column) => ':' . $column,
                $columns
            )
        );
        $sql = "INSERT INTO {$table} ({$cols}) VALUES ({$values})";
        return $sql;
    }
    public static function select(string $table, array $columns, $where = null, $order = null, int $limit = 0, int $offset = 0)
    {
        $cols = implode(',', $columns);
        $where = empty($where) ? '' : "WHERE " . implode(' AND ', $where);
        $order = empty($order) ? '' : "ORDER BY " . implode(',', $order);
        $limit = empty($limit) ? '' : "LIMIT " . $limit;
        $offset = empty($offset) ? '' : "OFFSET " . $offset;
        $sql = "SELECT {$cols} FROM {$table} {$where} {$order} {$limit} {$offset}";
        return $sql;
    }
}