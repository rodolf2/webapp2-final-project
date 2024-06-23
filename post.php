<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
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

        .post-container {
            background-color: #4A005B;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 600px;
        }

        .post-container h1 {
            margin-bottom: 20px;
            color: #39E09B;
        }

        #postDetails {
            text-align: left;
        }

        #postDetails h3 {
            margin-bottom: 20px;
            color: #39E09B;
        }

        #postDetails p {
            margin-bottom: 20px;
            background-color: #FFFFFF;
            color: #4A005B;
            padding: 20px;
            border-radius: 10px;
            white-space: pre-wrap;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .button-container form {
            display: inline;
        }

        .button-container button {
            background-color: #39E09B;
            color: #4A005B;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #2da17f;
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h1>Post Page</h1>
        <div id="postDetails">
        <?php
            require 'config.php'; 

            if (!isset($_SESSION['id'])) {
                header("Location: login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $post_id = $_GET['id'];

                        $query = "SELECT * FROM posts WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $post_id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . htmlspecialchars($post['title']) . '</h3>';
                            echo '<p>Body: ' . nl2br(htmlspecialchars($post['body'])) . '</p>';
                        } else {
                            echo "No post found with ID {$post_id}";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                    
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        ?>
        </div>
        <div class="button-container">
            <form method="post" action="posts.php">
                <button type="submit">Back</button>
            </form>
            <form method="post" action="logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
