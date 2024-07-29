<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #f0f0f0, #e0e0e0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .header i {
            font-size: 48px; /* Icon size */
            color: #668e8f; /* Teal color */
            margin-right: 10px;
        }
        h2 {
            margin: 0;
            color: #668e8f; /* Teal color for the title */
            font-size: 30px;
            font-weight: 900;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 9px;
            font-weight: 500;
            color: #777;
            text-align: left;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: calc(100% - 15px);
            padding: 12px 12px 12px 20px; /* Add padding on left for icon */
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 7px;
            background: #f5f5f5;
            color: #333;
            font-size: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #668e8f; /* Focus color to match header and button */
            box-shadow: 0 0 5px rgba(102, 142, 143, 0.2);
            outline: none;
        }
        .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #668e8f; /* Teal color */
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #4a6a6b; /* Darker shade for hover effect */
            transform: scale(1.04);
        }
        .sign-up {
            margin-top: 15px;
        }
        .sign-up a {
            color: #668e8f; /* Teal color for links */
            text-decoration: none;
            font-size: 14px;
        }
        .sign-up a:hover {
            text-decoration: underline;
        }
        p {
            margin-top: 25px;
        }
        a {
            color: #668e8f; /* Teal color for links */
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-user-plus"></i>
            <h2></h2>
        </div>
        <form action="signup_process.php" method="POST">
            <div class="form-group">
                <label for="username"></label>
                <i class="icon fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder=" username" required>
            </div>
            <div class="form-group">
                <label for="role"></label>
                <i class="icon fas fa-user-tag"></i>
                <select id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="userclient">User Client</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password"></label>
                <i class="icon fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder=" password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>
</body>
</html>
