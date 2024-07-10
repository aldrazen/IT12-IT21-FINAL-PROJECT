<?php
include 'connectionDB.php';

if (isset($_POST['token']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $hashed_token = hash("sha256", $token);

    $check_token_sql = "SELECT * FROM customer_tbl WHERE reset_token_hash = ?";
    $stmt = mysqli_prepare($connection, $check_token_sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $hashed_token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (strtotime($user["reset_token_expiry"]) > time()) {
                // Token is valid and not expired
                echo "Token is valid and hasn't expired.";
                //password checker
                if (strlen($password) < 12) {
                    echo "<script>alert('Password must have at least 8 characters.'); window.location.href = '../customer/customerRegister.php';</script>";
                    exit();
                }
                if (!preg_match("#[0-9]+#", $password)) {
                    echo "<script>alert('Password must have at least 1 number.'); window.location.href = '../customer/customerRegister.php';</script>";
                    exit();
                }
                if (!preg_match("#[A-Z]+#", $password)) {
                    echo "<script>alert('Password must have at least 1 uppercase character.'); window.location.href = '../customer/customerRegister.php';</script>";
                    exit();
                }
                $specialChars = preg_match('@[^\w]@', $password);
                if (!$specialChars) {
                    echo "<script>alert('Password must have at least 1 special character.'); window.location.href = '../customer/customerRegister.php';</script>";
                    exit();
                }
                if ($password !== $confirmPassword) {
                    echo "<script>alert('Your passwords do not match!');</script>";
                    exit();
                }
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE customer_tbl SET customer_password = ?, reset_token_hash = NULL, reset_token_expiry = NULL WHERE customer_ID = ?";

                $stmt2 = mysqli_prepare($connection, $sql);
                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, 'ss', $hashedPassword, $user["customer_ID"]);
                    $result2 = mysqli_stmt_execute($stmt2);
                    if ($result2) {
                        echo "<script> alert('Password updated successfully!'); window.location.href = '../customer/customerLogin.php'; </script>";
                        exit();
                    } else {
                        echo "<script>alert('Failed to updadte password!');window.location.href = '../customer/customerLogin.php';</script>";
                        exit();
                    }
                }
            } else {
                echo "<script>alert('Token has expired.');</script>";
                exit();
            }
        } else {
            echo "<script> alert('Request Expired'); window.location.href = '../customer/customerLogin.php'; </script>";
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('An error occured.'); window.location.href = '../customer/customerLogin.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Token required.');window.location.href = '../customer/customerLogin.php';</script>";
    exit();
}

mysqli_close($connection);
