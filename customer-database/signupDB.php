<?php
include 'connectionDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = isset($_POST["email"]) ? $_POST["email"] : "";
    $fullName = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
    $phoneNumber = isset($_POST["Phonenumber"]) ? $_POST["Phonenumber"] : "";
    $address = isset($_POST["Address"]) ? $_POST["Address"] : "";
    $password = htmlspecialchars(isset($_POST["password"])) ? $_POST["password"] : "";
    $confirmPassword = htmlspecialchars(isset($_POST["confirmPassword"])) ? $_POST["confirmPassword"] : "";
    // Email format validation
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('The email you entered is not valid. Try again'); window.location.href = '../customer/customerLogin.php';</script>";
        exit();
    }
    // API key for email validation
    $api_key = 'ebcdf5ae66004ec2a5b9727b10e37c1c';
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$userEmail",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);

    // Email deliverability check
    if (isset($data['deliverability']) && $data['deliverability'] === "UNDELIVERABLE") {
        echo "<script>alert('Email does not exist. Please enter a valid email address.'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }
    // Disposable email check
    if (isset($data["is_disposable_email"]["value"]) && $data["is_disposable_email"]["value"] === true) {
        echo "<script>alert('Disposable email addresses are not allowed.'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }

    // Check if email already exists
    $checkAccount = "SELECT * FROM customer_tbl WHERE customer_name = '$userEmail'";
    $result = mysqli_query($connection, $checkAccount);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('The email you entered is already registered. Try again'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }

    //password checker
    if (strlen($password) < 8) {
        echo "<script>alert('Password must have at least 8 characters.'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }
    if (!preg_match("#[0-9]+#", $password)) {
        echo "<script>alert('Password must have at least 1 number.'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }
    if (!preg_match("#[A-Z]+#", $password)) {
        echo "<script>alert('Password must have at least 1 uppercase letter.'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }

    // Password confirmation
    if ($password != $confirmPassword) {
        echo "<script>alert('Your password doesn\'t match!'); window.location.href = '../customer/customerRegister.php';</script>";
        exit();
    }
    // Hashing the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    //Generate account status token
    $token = bin2hex(random_bytes(16));
    $hashed_token = hash("sha256", $token);

    // Inserting the new user into the database
    $register_query = "INSERT INTO customer_tbl (customer_name, customer_username, customer_number, customer_address, customer_password, account_status_token) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $register_query);
    mysqli_stmt_bind_param($stmt, 'ssssss', $userEmail, $fullName, $phoneNumber, $address, $hashedPassword, $hashed_token);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        if ($result) {
            $mail = include '../mailer.php';
            $mail->setFrom('drazgamings@gmail.com', 'noreply@topshelf.com');
            $mail->addAddress($_POST['email']);
            $mail->Subject = "Account Activation";
            $mail->Body = <<<END
            Click <a href="http://localhost/IT12-IT21-FINAL-PROJECT/customer-database/activateAccount.php?token=$token">here</a> to activate your account.
          END;
            try {
                $mail->send();
                echo "<script> alert('Sign up successful! You will be redirected to your email to activate your account.');window.location.href = 'https://mail.google.com/mail/u/1/?ogbl#inbox';</script>";
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer error: {$mail->ErrorInfo}');window.location.href = '../customer/signupDB.php';</script>";
                exit();
            } finally {
                mysqli_close($connection);
            }
        } else {
            echo "<script> alert('Failed to update reset token.'); window.location.href = '../customer/signupDB.php'; </script>";
            exit();
        }
        echo "<script>alert('Registered successfully!'); window.location.href = '../customer/customerLogin.php';</script>";
    } else {
        error_log("Registration error: " . mysqli_error($connection));
        echo "<script>alert('Registration failed. Please try again.'); window.location.href = '../customer/customerRegister.php';</script>";
    }
} else {
    header("location: ../customer/customerHome.php");
    exit();
}
