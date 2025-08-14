<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// 1️⃣ Delete related bookings first
$stmt = $conn->prepare("DELETE FROM bookings WHERE event_id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

// 2️⃣ Now delete the event
$stmt = $conn->prepare("DELETE FROM events WHERE id=?");
$stmt->bind_param("i",$id);
if($stmt->execute()){
    header("Location: dashboard.php");
    exit;
} else {
    echo "Error: ".$conn->error;
}
?>
