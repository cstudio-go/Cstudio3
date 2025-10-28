<?php
session_start();
$file = "visitors.json";
$now = time();

// Load current data
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

// Clean old sessions (inactive > 60s)
foreach ($data as $id => $timestamp) {
    if ($now - $timestamp > 60) unset($data[$id]);
}

// Update current user
$data[session_id()] = $now;

// Save
file_put_contents($file, json_encode($data));

// Return count
echo count($data);
?>