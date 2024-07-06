<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="images/x-icon" href="../images/logo-bg.jpg" />
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.css" />
  <script src="../Bootstrap/js/bootstrap.js"></script>
  <script src="../script.js"></script>
  <link rel="stylesheet" href="../customerStyles/login.css" />
  <link rel="stylesheet" href="../customerStyles/footer.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:wght@400;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <title>Forgot Password</title>
</head>

<body>
  <div class="background-img d-flex align-items-center justify-content-center flex-column">
    <img class="logo" src="../images/logo-bg.jpg" alt="logo" />
    <h3 class="text-white">Reset Password</h3>
    <div class="container-fluid mt-3 d-flex flex-column align-items-center">
      <form action="../customer-database/sendPasswordReset.php" method="POST">
        <div class="form-outline mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control rounded-4 py-2 bg-transparent border-2" name="email" id="email"
            required />
        </div>
        <button type="submit" class="login py-2 w-100 mt-2 rounded-4">
          Send Request
        </button>
      </form>
    </div>
    <button class="goBack mt-3 bi bi-arrow-90deg-left rounded-3 px-2 py-1" onclick="login()">
      Return
    </button>
  </div>
</body>

</html>