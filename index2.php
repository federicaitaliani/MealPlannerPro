  <?php
     session_start();
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Glacial+Indifference&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>Design&Dine</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;  /* White background */
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        header {
            background-color: #fff;
            text-align: center;
            padding: 30px 0;
        }

        header h1 {
            font-family: 'Glacial Indifference', sans-serif;
            font-weight: 600;
            font-size: 4rem;
            text-transform: uppercase;
            color: #000;
            margin-bottom: 10px;
            letter-spacing: 5px;
        }

        header p {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0px;
            color: #444;
        }

        /* Hero Image Section */
        .hero-section {
            position: relative;
            margin-top: 20px;
            text-align: center;  /* Ensures the content is centered */
        }

        .kiwi {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
        }

        .hero-text {
            position: absolute;
            top: 40%;  /* Adjust this value to move the text up or down */
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        /* Food Emojis */
        .hero-icons {
            display: flex;
            justify-content: center;
            gap: 30px;  /* Space between the icons */
            margin-top: 20px;  /* Space between the text and icons */
        }

        .food-icon {
            font-size: 4rem;  /* Size of each emoji */
            transition: transform 0.3s ease;  /* Optional: add animation on hover */
        }

        .food-icon:hover {
            transform: scale(1.1);  /* Optional: add scaling effect on hover */
        }

        /* Features Section */
        .features {
            padding: 40px 0;
            background-color: #fff;  /* White background */
            text-align: center;
        }

        .features h2 {
            font-size: 2.2rem;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .features p {
            font-size: 1.2rem;
            color: #444;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
        }

        .features p strong {
            font-weight: bold;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        footer a {
            color: #f1f1f1;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Navbar */
        .top-nav {
            background-color: #ffffff;
            border-bottom: 1px solid #e4d426;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            height: 80px;  /* Reduced size of the logo */
            margin-right: 20px;  /* Space between logo and navigation links */
            margin-left: 0;  /* Align logo to the left */
        }

        nav a {
            color: #6a9a3c;  /* Earthy green */
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            margin: 0 15px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: #e4d426;
            color: white;
        }

        /* Button Styling */
        .cta-btn {
            background-color: #6a9a3c;  /* Green button */
            color: #fff;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.3s ease, background-color 0.3s ease;
            margin-top: 20px;
            display: inline-block;
        }

        .cta-btn:hover {
            transform: translateY(-5px);
            background-color: #5a8e34;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <div class="nav-container">
            <a href="index.html">
                <img src="logo.jpg" alt="Design&Dine Logo" class="logo">
            </a>
            <nav>
                <a href="gen-meals.html">FIND RECIPES</a>
                <a href="meal_plans.html">SAVED MEAL PLANS</a>
                <a href="about.html">ABOUT</a>
            </nav>
        </div>
    </div>

    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>DESIGN&DINE</h1>
            <p>Your personalized meal planning solution</p>
        </div>
        
        <div class="hero-section">
            <img src="kiwi.jpg" alt="Kiwi Image" class="kiwi">
            <div class="hero-text">
                <h2>Transform Your Ingredients into Delicious Meals</h2>
            </div>
            <!-- Food emoji icons -->
            <div class="hero-icons">
                <span class="food-icon">🍳</span>
                <span class="food-icon">🍔</span>
                <span class="food-icon">🥗</span>
                <span class="food-icon">🍕</span>
                <span class="food-icon">🍖</span>
            </div>
        </div>
    </header>
        
    <!-- Features Section -->
    <div class="features">
        <div class="container">
            <p><strong>Design&Dine</strong> helps you create personalized meal plans based on what you already have in your kitchen, and lets you save your favorites and build your shopping list with ease.</p>
            <a href="gen-meals.html" class="cta-btn">Generate Your Meal Plan</a>
        </div>
    </div>

    <footer>
    <div class="container">
        <!-- Login and Register links above the Contact Us line -->
        <div style="margin-bottom: 10px; text-align: center;">
            <?php
       


            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // If logged in, show the logout link
                echo '<a href="logout.php" style="color: rgb(220, 198, 30); font-size: 1.2rem; font-weight: bold; text-decoration: none;">Logout</a>';
            } else {
                // If not logged in, show the login and register links
                echo '<a href="login.html" style="color: rgb(220, 198, 30); font-size: 1.2rem; font-weight: bold; margin-right: 15px; text-decoration: none;">Login</a>';
                echo '<a href="register.html" style="color: rgb(220, 198, 30); font-size: 1.2rem; font-weight: bold; text-decoration: none;">Register</a>';
            }
            ?>
        </div>
        <p>&copy; 2024 Design&Dine. All rights reserved. 
            | <a href="mailto:support@designdine.com">Contact Us</a>
        </p>
    </div>
</footer>
</body>
