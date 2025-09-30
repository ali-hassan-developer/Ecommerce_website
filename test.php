<?php
include 'includes/db.php';// aapki Database class ka file

try {
    
    echo "Database connected successfully!";
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>