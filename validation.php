<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sign-up"])) {
   // Validate and sanitize user inputs
   $fname = filter_var ($_POST['fname'], FILTER_SANITIZE_STRING);
   $lname = filter_var ($_POST['lname'], FILTER_SANITIZE_STRING);
   $email = filter_var ($_POST['email'], FILTER_SANITIZE_EMAIL);
   $password = $_POST['password'];
   $confirm_password = $_POST['confirm_password'];
   $number = filter_var ($_POST['number'], FILTER_SANITIZE_STRING);
   $position = filter_var ($_POST['position'], FILTER_SANITIZE_STRING);

   // Validate email format
   if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {
      die("Invalid email format");
   }

   // Validate password and confirm_password match
   if ($password !== $confirm_password) {
      die("Passwords do not match");
   }

   // // Hash the password before storing it in the database
   // $hashed_password = password_hash ($password, PASSWORD_DEFAULT);

   // Extract the workplace type and ID from the select field
   $workplace_value = $_POST['workplace'];
   $workplace_type = substr ($workplace_value, 0, 1);
   $workplace_id = substr ($workplace_value, 1);

   // SQL query to insert data into the users table based on the workplace type
   if ($workplace_type === 'C') {
      $sql = "INSERT INTO users (fname, lname, email, password, number, position, company_id) 
               VALUES ('$fname', '$lname', '$email', '$password', '$number', '$position', '$workplace_id')";
   } elseif ($workplace_type === 'H') {
      $sql = "INSERT INTO users (fname, lname, email, password, number, position, hospital_id) 
               VALUES ('$fname', '$lname', '$email', '$password', '$number', '$position', '$workplace_id')";
   } else {
      die("Invalid workplace type");
   }

   // Execute the query
   if ($conn->query ($sql) === TRUE) {
      echo "New record created successfully";
   } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
   }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sign-in"])) {
   $email = filter_var ($_POST['email'], FILTER_SANITIZE_EMAIL);
   $password = $_POST['password'];

   // Use prepared statement to prevent SQL injection
   $stmt = $conn->prepare ("SELECT user_id, email, password FROM users WHERE email = ?");
   $stmt->bind_param ("s", $email);
   $stmt->execute ();
   $stmt->bind_result ($user_id, $db_email, $db_password);
   $stmt->fetch ();

   // Check if the entered password matches the stored plain-text password
   if ($password === $db_password) {
      echo "Sign in successful. User ID: $user_id";
      // Redirect or perform additional actions after successful sign-in
   } else {
      echo "Invalid email or password";
   }

   // Close statement
   $stmt->close ();
}

// Close connection
$conn->close ();