<?php

include 'connectionDB.php';
$token = $_GET['token'];
$hashed_token = hash("sha256", $token);

$get_account_status_token = "SELECT * FROM customer_tbl WHERE account_status_token =?";
$stmt = mysqli_prepare($connection, $get_account_status_token);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $hashed_token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $update_account_status_token = "UPDATE customer_tbl SET account_status_token = NULL WHERE customer_ID = ?";
        $stmt2 = mysqli_prepare($connection, $update_account_status_token);
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, 's', $user['customer_ID']);
            $result2 = mysqli_stmt_execute($stmt2);
            if ($result2) {
                echo "<script> alert('Account activated successfully! Login using your account now.');window.location.href = '../customer/customerLogin.php';</script>";
                exit();
            } else {
                echo "<script>alert('An error has occured.');window.location.href = '../customer/customerLogin.php';</script>";
                exit();
            }
        }
    } else {
        echo "<script> alert('Request Expired'); window.location.href = '../customer/customerLogin.php'; </script>";
        exit();
    }
} else {
    echo "<script>alert('An error occured.'); window.location.href = '../customer/customerLogin.php';</script>";
    exit();
}
mysqli_close($connection);
