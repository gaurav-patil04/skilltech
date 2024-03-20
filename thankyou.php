<?php
    session_start();
    
    if(!isset($_SESSION['email'])){
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="courses.css"> -->
    <style>
    .nav{
        display: flex;
        justify-content: space-between;
        height: 70px;
        align-items: center;
        background-image: linear-gradient(to right, #93A5CF,#E4EfE9);
        position: sticky;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
    .logo{
        margin: 5px;
    }
    body{
        background-color: #282854;
    }
    .listu{
            list-style-type: none;
            display: inline;
            font-weight: bolder;
            margin-left: -140px;
        }
        .listu > a{
            text-decoration: none;
        }
        .listu > a:hover{
            text-decoration: underline;
        }
        .list{
            padding-left: 15px;
            display: inline;
            font-size: large;
            cursor: pointer;
            color: black;
        }
        .logout{
            margin-right: 12px;
        }
        .profile-container {
            position: relative;
            display: inline-block;
            margin-right: 12px;

        }

        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            display: none;
        }

        .profile-dropdown a{
            color: #000000;
            width: 200px;
            padding: 2px 8px;
            text-decoration: none;
            display: block;
        }
        .profile-dropdown p{
            padding: 2px 8px;
            font-weight: bolder;
        }

        .profile-image {
            border-radius: 50%;
            cursor: pointer;
        }

        /* .profile-container:hover .profile-dropdown {
            display: block;
        } */
        .logout{
            font-weight: bolder;
        }
        .welcome{
            position: absolute;
            right: 72px;
        }
        hr{
            margin: 0.5rem 0;
        }
        *{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .content >h1{
            color: white;
            margin-top: 150px;
        }
        .content > a{
            margin-top: 20px;
        }
    </style>
    <script>
        function display(){
            var dropdown = document.getElementById("dropdown");

            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <div class="nav">
        <div class="d-flex align-items-center">
            <img src="b6ea43e6-8f57-4472-bc6b-d27cd3921f1c.png" alt="Logo" width="60px" height="60px" class="logo">
            <h3 style="font-family: Georgia, 'Times New Roman', Times, serif;">SkillTech</h3>
        </div>
        <div class="menu">
            <ul class="listu">
                <a href="home.php"><li class="list">Home</li></a>
                <a href="categories.php"><li class="list">Courses</li></a>
                <a href="aboutus.php"><li class="list">About us</li></a>
                <a href="contact-us.php"><li class="list">Contact us</li></a>
            </ul>
        </div>
        <div class="welcome">
            <h5>
                <?php echo "Welcome, " . $_SESSION['name'] ?>
            </h5>
        </div>
        <div class="profile-container">
            <img class="profile-image" src="profile.jpg" alt="Profile Picture" width="42px" height="42px" onclick="display()">
            <div class="profile-dropdown" id="dropdown">
                <p>
                    <?php echo "Hi, " . $_SESSION['name'] ?>
                </p>
                <a href="#">My Courses</a>
                <hr>
                <a href="edit_profile.php">Edit Profile</a>
                <hr>
                <a href="transactions.php">Transactions</a>
                <hr>
                <!-- <center> -->
                <a href="logout.php" style="color:blue;" class="logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Logout</a>
                <!-- </center> -->
            </div>
      </div>
    </div>

    <center>
        <div class="content">
            <h1>Thank You for Purchasing <?php echo $_SESSION['name'] ?></h1>
            <a href="home.php" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                  </svg>
                Go to Home
            </a>
        </div>
    </center>
</body>
</html>