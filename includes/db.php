<?php
$host = 'localhost';
$username = 'root';
$pass = '';
$db = 'ecommerce_db';

$conn = mysqli_connect($host, $username, $pass, $db);

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Execute raw query
function query($sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    return $result;
}

// Fetch single row
function fetch_assoc($sql)
{
    $res = query($sql);
    return mysqli_fetch_assoc($res);
}

// Fetch all rows
function fetch_all($sql)
{
    $res = query($sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}

// Insert record
function insert($table, $data)
{
    global $conn;

    // Escape all values properly
    $escaped_values = array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, array_values($data));

    $columns = implode(",", array_keys($data));
    $values = "'" . implode("','", $escaped_values) . "'";

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    query($sql);

    // Get last inserted id
    $last_id = mysqli_insert_id($conn);

    // Fetch full inserted row
    $res = query("SELECT * FROM $table WHERE id = $last_id");
    return mysqli_fetch_assoc($res);
}

// Update record by ID
function update($table, $data, $id)
{
    global $conn;
    $set = [];
    foreach ($data as $col => $val) {
        $val = mysqli_real_escape_string($conn, $val);
        $set[] = "$col='$val'";
    }
    $sql = "UPDATE $table SET " . implode(",", $set) . " WHERE id=" . intval($id);
    return query($sql);
}

// Delete record by ID
function delete($table, $id)
{
    $sql = "DELETE FROM $table WHERE id=" . intval($id);
    return query($sql);
}

// Count rows
function count_rows($table, $where = '1')
{
    $res = query("SELECT COUNT(*) as count FROM $table WHERE $where");
    $row = mysqli_fetch_assoc($res);
    return intval($row['count']);
}
function selectAll($table, $where = "1") {
    $sql = "SELECT * FROM $table WHERE $where";
    return fetch_all($sql);
}
