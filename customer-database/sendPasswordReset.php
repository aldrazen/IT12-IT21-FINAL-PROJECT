<?php
include 'connectionDB.php';

if (isset($_POST["email"])) {
  $userEmail = trim($_POST["email"]); // Trim whitespace 

  // Check if email exists sa db
  $checkAccount = "SELECT * FROM customer_tbl WHERE customer_name = ?";
  $stmt = mysqli_prepare($connection, $checkAccount);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      // Generate ug token and expiry date
      $token = bin2hex(random_bytes(16));
      $hashed_token = hash("sha256", $token);
      $token_expiry = date("Y-m-d H:i:s", time() + 60 * 5);

      //SQL statement to prevent SQL injection
      $send_token_query = "UPDATE customer_tbl SET reset_token_hash = ?, reset_token_expiry = ? WHERE customer_name = ?";
      $stmt = mysqli_prepare($connection, $send_token_query);
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $hashed_token, $token_expiry, $userEmail);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
          $mail = include '../mailer.php';
          $mail->setFrom('drazgamings@gmail.com', 'noreply@topshelf.com');
          $mail->addAddress($userEmail);
          $mail->Subject = "Password Reset";
          $mail->Body = <<<END
            Click <a href="http://localhost/IT12-IT21-FINAL-PROJECT/customer/resetPasswordForm.php?token=$token">here</a> to reset your password.
          END;
          try {
            $mail->send();
            echo "<script> alert('Message sent! Check your email.'); window.open('', '_self').close(); </script>";
            exit();
          } catch (Exception $e) {
            echo "<script> alert('Message could not be sent. Mailer error: {$mail->ErrorInfo}'); window.location.href = '../customer/forgotpassword.php'; </script>";
            exit();
          } finally {
            mysqli_close($connection);
          }
        } else {
          echo "<script> alert('Failed to update reset token.'); window.location.href = '../customer/forgotpassword.php'; </script>";
          exit();
        }
      } else {
        echo "<script> alert('Failed to prepare token update statement.'); window.location.href = '../customer/forgotpassword.php'; </script>";
        exit();
      }
    } else {
      echo "<script> alert('Email does not exist.'); window.location.href = '../customer/forgotpassword.php'; </script>";
      exit();
    }
    mysqli_stmt_close($stmt);
  } else {
    echo "<script> alert('Failed to prepare email check statement.'); window.location.href = '../customer/forgotpassword.php'; </script>";
    exit();
  }
} else {
  echo "<script> alert('Email is required.'); window.location.href = '../customer/forgotpassword.php'; </script>";
  exit();
}
