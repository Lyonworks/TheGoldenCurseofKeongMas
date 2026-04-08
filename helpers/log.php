<?php

function logActivity($name, $action, $description)
{
    global $conn;

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO activity (name, action, description, created_at)
         VALUES (?, ?, ?, NOW())"
    );

    mysqli_stmt_bind_param($stmt, "sss", $name, $action, $description);
    mysqli_stmt_execute($stmt);
}
