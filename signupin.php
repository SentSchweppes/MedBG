<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/css/signupin.css">
   <script type="module" src="/js/signupin.js"></script>
   <title>Login/Signup</title>
</head>

<body>
   <?php
   include 'connection.php';

   $sql = "SELECT company_id, name FROM companies";
   $result = $conn->query ($sql);

   if ($result->num_rows > 0) {
      $companies = $result->fetch_all (MYSQLI_ASSOC);
   } else {
      $companies = array();
   }

   $conn->close ();
   ?>

   <?php
   include 'connection.php';

   $sql = "SELECT hospital_id, name FROM hospitals";
   $result = $conn->query ($sql);

   if ($result->num_rows > 0) {
      $hospitals = $result->fetch_all (MYSQLI_ASSOC);
   } else {
      $hospitals = array();
   }

   $conn->close ();
   ?>

   <div id="login" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-body">
               <div class="container" id="container">
                  <div class="form-container sign-up-container">
                     <form action="validation.php" method="POST">
                        <br><br><br>
                        <h1 style="margin-top: 60px;">Create Account</h1>
                        <input type="text" name="fname" placeholder="First Name" />
                        <input type="text" name="lname" placeholder="Last Name" />
                        <input type="email" name="email" placeholder="Email" />
                        <input type="password" name="password" placeholder="Password" />
                        <input type="password" name="confirm_password" placeholder="Confirm Password" />
                        <input type="text" name="number" placeholder="Number" />
                        <input type="text" name="position" placeholder="Position" />
                        <select id="workplace" name="workplace">
                           <?php
                           foreach ($companies as $company) {
                              echo "<option value='C{$company['company_id']}'>{$company['name']}</option>";
                           }
                           foreach ($hospitals as $hospital) {
                              echo "<option value='H{$hospital['hospital_id']}'>{$hospital['name']}</option>";
                           }
                           ?>
                        </select>
                        <br><br>
                        <button type="submit" name="sign-up" style="margin-bottom: 60px;">Sign Up</button>
                     </form>
                  </div>
                  <div class="form-container sign-in-container">
                     <form action="validation.php" method="POST">
                        <h1>Sign in</h1>
                        <input type="email" name="email" placeholder="Email" />
                        <input type="password" name="password" placeholder="Password" />
                        <a href="#">Forgot your password?</a>
                        <button type="submit" name="sign-in">Sign In</button>
                     </form>
                  </div>
                  <div class="overlay-container">
                     <div class="overlay">
                        <div class="overlay-panel overlay-left">
                           <h1>Welcome Back!</h1>
                           <p>To go into your profile please login with your personal info</p>
                           <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                           <h1>Hello! Missing an account?</h1>
                           <p>Enter your personal details and start journey with us</p>
                           <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>