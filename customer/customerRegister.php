<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="images/x-icon" href="../images/logo-bg.jpg" />
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.css" />
  <script src="../Bootstrap/js/bootstrap.js"></script>
  <script src="../script.js"></script>
  <link rel="stylesheet" href="../customerStyles/register.css" />
  <link rel="stylesheet" href="../customerStyles/footer.css" />
  <link rel="preconnect" href="../https://fonts.googleapis.com" />
  <link rel="preconnect" href="../https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:wght@400;700&display=swap"
    rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Baskervville&family=Krona+One&family=Roboto:wght@400;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <title>User Login</title>
</head>

<body>
  <div class="background-img d-flex align-items-center justify-content-center flex-column">
    <img class="logo" src="../images/logo-bg.jpg" alt="logo" />
    <h3 class="text-white">Sign up</h3>
    <div class="container w-50 mt-3">
      <form action="../customer-database/signupDB.php" method="post">
        <div class="row mt-2">
          <div class="col-lg-6 mt-2">
            <div class="form-outline">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control rounded-4 py-2 bg-transparent border-2" name="email" id="email">
            </div>
          </div>

          <div class="col-lg-6 mt-2">
            <div class="form-outline">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control rounded-4 py-2 bg-transparent border-2" name="fullname"
                id="fullname">
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-lg-6">
            <div class="form-outline">
              <label for="Phonenumber" class="form-label">Phone Number</label>
              <input type="number" class="form-control rounded-4 py-2 bg-transparent border-2" name="Phonenumber"
                id="Phonenumber">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-outline">
              <label for="Address" class="form-label">Address</label>
              <input type="text" class="form-control rounded-4 py-2 bg-transparent border-2" name="Address"
                id="Address">
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-lg-6">
            <div class="form-outline">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control rounded-4 py-2 bg-transparent border-2" name="password"
                id="password">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-outline">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control rounded-4 py-2 bg-transparent border-2" name="confirmPassword"
                id="confirmPassword">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <button type="submit" name="register" class="signup py-2 rounded-4 mt-lg-5 my-3 w-50">
                Sign up
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <button class="goBack bi bi-arrow-90deg-left rounded-3 px-2 py-1" onclick="login()">
      Return
    </button>
  </div>
</body>

</html>