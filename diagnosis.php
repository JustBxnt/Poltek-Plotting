<?php
$dbPath = __DIR__ . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "MISSING_DB\n";
    exit(0);
}
try {
    $pdo = new PDO('sqlite:' . $dbPath);
    foreach ($pdo->query("SELECT name FROM sqlite_master WHERE type='table';") as $row) {
        echo $row['name'] . "\n";
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
