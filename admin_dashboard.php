<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin.php");
    exit();
}

// Retrieve user info from session
$users = $_SESSION['users'] ?? []; // Get all users from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #8360c3, #2ebf91);
            margin: 0;
            padding: 0;
        }
        .admin-container {
            max-width: 700px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
        }
        .user-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-radius: 8px;
        }
        .user-info table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .user-info th, .user-info td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s;
        }
        .user-info th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .user-info tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .user-info tr:hover {
            background-color: #ddd;
        }
        .user-info td {
            font-size: 16px;
            color: #333;
        }
        .logout-btn {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 18px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h2> Admin!</h2>

    <div class="user-info">
        <h3>Logged In Users:</h3>
        <?php if (empty($users)): ?>
            <p>No users logged in yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <a class="logout-btn" href="index.php">Logout</a>
</div>

</body>
</html>