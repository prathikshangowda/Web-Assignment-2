<?php
// Database connection details
$host = 'localhost';
$dbname = 'captcha_registration';
$username = 'root'; // Default username for XAMPP
$password = '';     // Default password for XAMPP (leave empty)

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing

    try {
        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);

        echo "Registration Successful!<br>";
        echo "Name: $name<br>";
        echo "Email: $email<br>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate email error
            echo "Error: Email already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
