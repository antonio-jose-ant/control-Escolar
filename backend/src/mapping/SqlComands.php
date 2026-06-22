<?php
namespace App\mapping;
class SqlComands
{
    public static function INSERT(string $table, array $columns)
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
    public static function SELECT(string $table, array $columns, $where = null, $order = null, int $limit = 0, int $offset = 0)
    {
        $cols = implode(',', $columns);
        $where = empty($where) ? '' : "WHERE " . implode(' AND ', $where);
        $order = empty($order) ? '' : "ORDER BY " . implode(',', $order);
        $limit = empty($limit) ? '' : "LIMIT " . $limit;
        $offset = empty($offset) ? '' : "OFFSET " . $offset;
        $sql = "SELECT {$cols} FROM {$table} {$where} {$order} {$limit} {$offset}";
        return $sql;
    }
    public static function UPDATE(string $table, array $columns, array $where): string
    {

        $set = implode(
            ', ',
            array_map(
                fn($column) => "{$column} = :{$column}",
                $columns
            )
        );

        $sql = "UPDATE {$table} SET {$set}";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return $sql;
    }
    public static function COUNT(string $table, array $where = []): string
    {

        $sql = "SELECT COUNT(*) AS total FROM {$table}";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return $sql;
    }

    public static function DELETE(string $table, array $where): string
    {

        $sql = "DELETE FROM {$table}";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return $sql;
    }

    public static function EXISTS(string $table, array $where = []): string
    {

        $sql = "SELECT EXISTS(";
        $sql .= "SELECT 1 FROM {$table}";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= ") AS exist";

        return $sql;
    }

    public static function TRUNCATE(string $table): string
    {
        return "TRUNCATE TABLE {$table}";
    }
    public static function SearchData()
    {

    }
}