<?php
include '../php/conn.php';

if (isset($_GET['year_level'])) {
    $yearLevel = $_GET['year_level'];

    // Replace 'class' with your actual table name
    $sql = "SELECT classname FROM class WHERE yearlevelid = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $yearLevel);
    $statement->execute();
    $result = $statement->get_result();
    $classes = [];

    while ($row = $result->fetch_assoc()) {
        $classes[] = $row['classname'];
    }

    $statement->close();

    header('Content-Type: application/json');
    echo json_encode($classes);
} else {
    echo json_encode([]);
}
?>
