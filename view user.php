<?php
$con = new mysqli("localhost", "root", "", "event");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Block user logic
if (isset($_POST['block_user'])) {
    $userId = $_POST['user_id']; // Correct the variable name here
    $blockQuery = "UPDATE signup SET action='blocked' WHERE userid='$userId'";
    $con->query($blockQuery);
}

// Fetch all users
$usersQuery = "SELECT userid, username, email FROM signup WHERE action IS NULL";
$result = $con->query($usersQuery);
$users = $result->fetch_all(MYSQLI_ASSOC);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="view user.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-container">
                <h1>Welcome, Admin</h1>
                <a href="logout.html" class="logout">Logout</a>
            </div>
        </nav>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="view user.php">View Users</a></li>
                <li><a href="view_booking.php">View Bookings</a></li>
                <li><a href="manage_booking.php">Manage Bookings</a></li>
                <li><a href="view_feedback.php">View Feedback</a></li>
                <li><a href="manage_cancel.php">View cancels</a></li>
                <li><a href="manage_confirm.php">View Cofirmed bookings</a></li>


            </ul>
        </aside>
        
        <main class="main-content">
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4">No users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['userid']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['userid']); ?>">
                                    <button type="submit" name="block_user">Block</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
    
    <footer>
        <p>&copy; 2024 Your Company</p>
    </footer>
</body>
</html>