<?php
require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    if ($pdo) {
        // echo "Connected to the $db database successfully!";

        if($_SERVER['REQUEST_METHOD'] === "POST") {
        
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute(['username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('password123' === $password) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: posts.php');
                    exit; 
                } else {
                    echo "Invalid Password!";
                }
            } else {
                echo "User not found!";
            }
        
        }       
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #4A005B;
    color: #FFFFFF;
}

.login-container {
    text-align: center;
    padding: 40px;
    border-radius: 10px;
    background-color: #4A005B; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

h2 {
    margin-bottom: 10px;
    color: #39E09B;
}

p {
    margin-bottom: 30px;
    color: #FFFFFF;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

input[type="text"], input[type="password"] {
    padding: 15px;
    margin: 10px 0;
    border: 2px solid #FFFFFF;
    border-radius: 30px;
    width: 250px;
    background-color: transparent;
    color: #FFFFFF;
    text-align: center;
    outline: none;
}

button {
    padding: 15px 30px;
    border: none;
    border-radius: 30px;
    background-color: #39E09B;
    color: #4A005B;
    font-size: 16px;
    cursor: pointer;
    outline: none;
    margin-top: 20px;
}

button:hover {
    background-color: #2EBD89;
}

footer {
    position: absolute;
    bottom: 10px;
    width: 100%;
    text-align: center;
    font-size: 12px;
    color: #FFFFFF;
}

    </style>
</head> 
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" id="username" placeholder="Enter username" name="username" required>
            <input type="password" id="password" placeholder="Enter password" name="password" required>
            <button id="submit">Login</button>
        </form>
    </div>
</body>

<!-- <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        fetch("https://jsonplaceholder.typicode.com/users")
            .then(response => response.json())
            .then(users => {
                const user = users.find(user => user.username === username);

                if (user) {
                    if (password === "password") {
                        window.location.href = "posts.php";
                    } else {
                        alert("Incorrect password!");
                    }
                } else {
                    alert("User not found!");
                }
            })
            .catch(error => alert("Error fetching users:", error));
    });
</script> -->
</html>