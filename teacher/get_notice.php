<?php
require_once '../db/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM notices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $notice = $result->fetch_assoc();
        echo json_encode($notice);
    } else {
        echo json_encode(["error" => "Notice not found"]);
    }
    
    $stmt->close();
}
?>
