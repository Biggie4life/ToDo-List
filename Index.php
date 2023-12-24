<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&family=Rubik+Scribble&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            background: linear-gradient( #FF0000, #FF4500); /* Red to Orange gradient */
            height: 100vh; /* Ensure the gradient covers the entire viewport height */
            margin: 0; /* Remove default margin */
        
        }

        .container {
            display: inline-block;
            margin-top: 150px;
            margin-left: 150px;
            margin-right: 150px; /* Add margin for spacing between buttons */
        }

        button {
            background-color: #fff; /* Button background color */
            padding: 10px 20px; /* Adjust padding as needed */
            border: none;
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.8); /* Shadow */
            cursor: pointer;
        }

        button img {
            max-width: 100%; /* Ensure the image doesn't exceed the button width */
            height: auto;
        }

        h2 {
            color: #fff; /* Set text color to white for better contrast */
        }
    </style>
    <title>Todo List Dashboard</title>
</head>
<body>
    <h2>Welcome to Your Todo List</h2>
    
    <div class="container">
        <a href="Register.php">
            <button type="button">
                <img src="Images/icons8-user-100.png" alt="User Icon">
                <br>Register</br>
            </button>
        </a>
    
    </div>
    <div class="container">
        <a href="Login.php">
            <button type="button">
                <img src="Images/icons8-user-100.png" alt="User Icon">
                <br>Login</br>
            </button>
        </a>
    </div>
</body>
</html>
