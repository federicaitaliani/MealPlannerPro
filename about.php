<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Glacial+Indifference&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>About Us - Design&Dine</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
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
            font-size: 3rem;
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

        /* About Section */
        .about-section {
            padding: 60px 0;
            text-align: center;
            background-color: #faf3e0; /* Light Beige */
            position: relative;
        }

        .about-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            position: relative;
            display: inline-block; /* Makes the background width fit the content */
            padding-bottom: 10px;
        }

        .about-section h2::after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background-color: #7a9d3f; /* Dark Green */
            margin: 20px auto 0;
        }

        .about-section p {
            font-size: 1.2rem;
            color: #444;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
        }

        .about-section p strong {
            font-weight: bold;
        }

        /* Icons and Features Section */
/* Icons and Features Section */
.features {
    display: flex;
    justify-content: space-around;
    margin-top: 40px;
    gap: 15px;  /* Reduced gap between the boxes */
    text-align: center;
}

.feature {
    padding: 20px;
    background-color: #f1f1f1; /* Default light background */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    max-width: 450px; /* Optional: Add maximum width for better spacing */
}
.features {
    display: flex;
    justify-content: space-around;
    margin-top: 40px;
    gap: 15px;  /* Reduced gap between the boxes */
    text-align: center;
    margin-bottom: 30px; /* Added margin to create space between features and footer */
}


/* Enhanced Background Colors */
.feature:nth-child(1) {
    background-color: #75a8465e; /* Light Yellow */
}

.feature:nth-child(2) {
    background-color: #75a8465e; /* Light Mint Green */
}

.feature:nth-child(3) {
    background-color: #75a8465e; /* Light Peach */
}

.feature:hover {
    transform: translateY(-10px);
}

.feature-icon {
    font-size: 3rem;
    color: #7a9d3f;
    margin-bottom: 15px;
}

.feature h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.feature p {
    font-size: 1rem;
    color: #444;
}


        .feature {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .feature:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            color: #7a9d3f;
            margin-bottom: 15px;
        }

        .feature h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Visual Section */
        .visual-section {
            position: relative;
            margin-top: 20px;
            text-align: center;
        }

        .visual-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Footer Section */
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
            height: 80px;
            margin-right: 20px;
            margin-left: 0;
        }

        nav a {
            color: #6a9a3c;
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
    </style>
</head>
<body>

    <div class="top-nav">
        <div class="nav-container">
            <a href="index.html">
                <img src="logo.jpg" alt="Design&Dine Logo" class="logo">
            </a>
            <nav>
                <a href="gen-meals.html">RECIPES</a>
                <a href="saved.html">FAVORITES</a>
                <a href="shop_list.html">CART</a>
                <a href="about.html">ABOUT</a>
            </nav>

        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <p><strong>Design&Dine</strong> is a personalized meal planning service that helps you optimize your kitchen ingredients by suggesting delicious, easy-to-make recipes. Whether you're an experienced cook or a novice, Design&Dine allows you to make the most of what you already have, saving time and money. Our mission is to help busy individuals and families make healthy, flavorful meals that fit their dietary preferences.</p>
            <p>Our platform is designed with simplicity and efficiency in mind. By understanding your kitchen inventory, we suggest tailored meal plans that are easy to follow and cost-effective. We believe meal planning should be accessible to everyone, and that's why we offer an intuitive interface that makes it fun and easy to plan your meals in just a few clicks.</p>
        </div>
    </div>

    <!-- Icons and Features Section -->
    <div class="features">
        <div class="feature">
            <div class="feature-icon">🍳</div>
            <h3>Easy Recipes</h3>
            <p>Quick, healthy, and customizable meal ideas based on what you already have in your kitchen.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">❤️</div>
            <h3>Save You Favorites</h3>
            <p>Keep track of the recipes that catch your eye. Save your favorite dishes and easily revisit them whenever you're ready to cook!</p>
        </div>
        <div class="feature">
            <div class="feature-icon">🛒</div>
            <h3>Grocery List</h3>
            <p>Generate a shopping list based on your meal plans, making it easier to grab what you need.</p>
        </div>
    </div>

<footer>
    <div class="container">
        <!-- Login and Register links above the Contact Us line -->
        <div style="margin-bottom: 10px; text-align: center;">
            <a href="login.html" style="color: yellow; font-size: 1.2rem; font-weight: bold; margin-right: 15px; text-decoration: none;">Login</a>
            <a href="register.html" style="color: yellow; font-size: 1.2rem; font-weight: bold; text-decoration: none;">Register</a>
        </div>
        <p>&copy; 2024 Design&Dine. All rights reserved. 
            | <a href="mailto:support@designdine.com">Contact Us</a> 
        </p>
    </div>
</footer>
