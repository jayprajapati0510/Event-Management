<?php
session_start();
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$message = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $date = $_POST['date'];
    $seats = $_POST['seats'];

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, seats) VALUES (?,?,?,?)");
    $stmt->bind_param("sssi",$title,$desc,$date,$seats);

    if($stmt->execute()){
        $message = "Event Added Successfully! <a href='dashboard.php'>Back</a>";
    } else {
        $message = "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
        padding: 40px 0;
    }
    h2 {
        text-align: center;
        color: #343a40;
        margin-bottom: 25px;
    }
    .form-container {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        max-width: 600px;
        margin: auto;
    }
    .btn {
        border-radius: 8px;
        font-weight: bold;
    }
    .btn:hover {
        opacity: 0.9;
    }
    @media (max-width:768px){
        .form-container {
            padding: 20px;
            width: 90%;
        }
    }
  </style>
</head>
<body>
<div class="form-container">
    <h2>Add Event</h2>
    <?php if($message) echo '<div class="alert alert-info">'.$message.'</div>'; ?>
    <form method="POST">
        <div class="mb-3">
            <input type="text" name="title" class="form-control" placeholder="Event Title" required>
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control" placeholder="Event Description" required></textarea>
        </div>
        <div class="mb-3">
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="number" name="seats" class="form-control" placeholder="Seats Available" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
