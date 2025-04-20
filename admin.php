<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Admin Login</h2>
    
    <form action="admin_auth.php" method="POST"> <!-- Change action to admin_auth.php -->
      <input type="text" name="admin_username" placeholder="Username" required>
      <input type="password" name="admin_password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
