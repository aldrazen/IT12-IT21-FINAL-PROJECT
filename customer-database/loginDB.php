<?php

include 'connectionDB.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
  $userEmail = $_POST['email'];
  $password = $_POST['password'];

  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
    echo "<script>alert('The email you entered is not valid. Try again'); window.location.href = '../customer/customerLogin.php';</script>";
    exit();
  }
  $login_query = "SELECT * FROM customer_tbl WHERE customer_name = '$userEmail'";
  $result = mysqli_query($connection, $login_query);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['account_status_token'] === NULL) {
      if (password_verify($password, $row['customer_password'])) {
        session_start();
        $_SESSION['customerID'] = $row['customer_ID'];
        $_SESSION['email'] = $row['customer_name'];
        $_SESSION['fullname'] = $row['customer_username'];
        $_SESSION['number'] = $row['customer_number'];
        $_SESSION['address'] = $row['customer_address'];
        $_SESSION['password'] = $row['customer_password'];
        header("Location: ../customer/customerHome.php");
        exit();
      } else {
        echo
        "<script>alert('Your password is incorrect.'); window.location.href = '../customer/customerLogin.php';</script>";
        exit();
      }
    } else {
      echo
      "<script>alert('Account not registered.'); window.location.href = '../customer/customerLogin.php';</script>";
      exit();
    }
  } else {
    echo
    "<script>alert('Account not registered.'); window.location.href = '../customer/customerLogin.php';</script>";
    exit();
  }
} else {
  header("location: ../Main/homepage.php");
  exit();
}
