<?php
include 'connectionDB.php';

session_start();

if (isset($_POST['update'])) {
  $customerID = $_SESSION['customerID'];
  $userEmail = $_POST['email'];
  $fullName = $_POST['fullname'];
  $phoneNumber = $_POST['phoneNumber'];
  $newPassword = $_POST['password'];
  $address = $_POST['address'];
  $current_email = $_POST['current_email'];
  $current_password = $_POST['current_password'];
  $confirm_password = $_POST['confirmPassword'];

  // Verify current password
  $confirm_query = "SELECT * FROM customer_tbl WHERE customer_name = '$current_email'";
  $confirm_result = mysqli_query($connection, $confirm_query);

  if (mysqli_num_rows($confirm_result) === 1) {
    $row = mysqli_fetch_assoc($confirm_result);


    if (password_verify($current_password, $row['customer_password'])) {

      // Check if the phone number nag exist na
      $check_query_phoneNumber = "SELECT * FROM customer_tbl WHERE `customer_number` = '$phoneNumber' AND `customer_ID` != $customerID";
      $check_result_phoneNumber = mysqli_query($connection, $check_query_phoneNumber);
      if (mysqli_num_rows($check_result_phoneNumber) > 0) {
        echo "<script> alert('The phone number you entered is already owned by another registered user.'); window.location.href = '../customer/customerUpdate.php'; </script>";
        exit();
      }

      if ($newPassword != $confirm_password) {
        echo "<script>alert('Your password doesn\'t match!'); window.location.href = '../customer/customerUpdate.php';</script>";
        exit();
      }

      // Prepare the update query
      $update_query = "UPDATE customer_tbl SET `customer_username` = '$fullName', `customer_number` = '$phoneNumber', `customer_address` = '$address'";

      // Only update the password if a new one is provided
      if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $update_query .= ", `customer_password` = '$hashedPassword'";
      }

      $update_query .= " WHERE customer_ID = '$customerID'";
      $result = mysqli_query($connection, $update_query);

      if ($result) {
        $_SESSION['email'] = $userEmail;
        $_SESSION['fullname'] = $fullName;
        $_SESSION['number'] = $phoneNumber;
        $_SESSION['address'] = $address;
        echo "<script> alert('Account updated successfully!'); window.location.href = '../customer/customerUpdate.php'; </script>";
        exit();
      } else {
        echo "<script> alert('Failed to update account. Try again'); window.location.href = '../customer/customerUpdate.php'; </script>";
      }
    } else {
      echo "<script> alert('Password Incorrect.'); window.location.href = '../customer/customerUpdate.php'; </script>";
      exit();
    }
  } else {
    echo "<script> alert('Account not registered. Try again'); window.location.href = '../customer/customerUpdate.php'; </script>";
    exit();
  }
} else {
  header('Location: ../customer/customerHome.php');
  exit();
}
