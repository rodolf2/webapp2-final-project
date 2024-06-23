<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
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

.posts-container {
    background-color: #4A005B; 
    border-radius: 10px;
    padding: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    text-align: center;
    width: 600px;
}

.posts-container h1 {
    margin-bottom: 20px;
    color: #39E09B;
}

#postLists {
    list-style-type: none;
    padding: 0;
}

#postLists li {
    background-color: #FFFFFF;
    border-radius: 30px;
    margin: 10px 0;
    padding: 10px;
    color: #4A005B;
    font-size: 18px;
}

#postLists li a {
    text-decoration: none;
    color: inherit;
    display: block;
    padding: 10px;
}

#postLists li:hover {
    background-color: #39E09B;
    color: #FFFFFF;
}

#postLists li a:hover {
    color: #FFFFFF;
}

    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require 'config.php';

            if (!isset($_SESSION['id'])) {
                header("Location: post.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' =>$_SESSION['id']]);

                    /*
                     * First approach using fetchAll and foreach loop
                     */
                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    }

                    /*
                     * Second approach using fetch and while loop
                     */
                    // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                    // echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    // }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("https://jsonplaceholder.typicode.com/posts")
            .then(response => response.json())
            .then(posts => {
                const postLists = document.getElementById("postLists");

                // posts = posts.slice(0, 10);
                posts.forEach(post => {
                    const li = document.createElement("li");
                    li.textContent = post.title;
                    li.setAttribute("data-id", post.id);
                    li.addEventListener("click", function() {
                        const id = this.getAttribute("data-id");
                        // window.location.href = "post.html?id=" + id;
                        window.location.href = `post.php?id=${id}`;
                    });
                    postLists.appendChild(li);
                });
            })
            .catch(error => console.error("Error fetching posts:", error));
    });
</script> -->
</html>