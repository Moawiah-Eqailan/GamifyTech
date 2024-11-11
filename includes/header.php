<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: ../NextLevelTech/index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon"
        href="assets/images/logo/1302365453812760631remix-1730585196342.png" />

    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    </head>

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <style>
    .logo {
        font-family: "Righteous", sans-serif;
        color: #ce2929;
        text-transform: uppercase;
        font-size: 17px;
        font-weight: 600px;
    }

  

    .navbar-nav {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .nav-item a {
        text-align: center;
        margin: 0 15px;
    }

    /* Style for the Login Button */
    .gaming-button {
        background-color: #629584;
        color: #fff;
        font-weight: bold;
        padding: 8px 16px;
        /* Reduced padding for a smaller button */
        border: 1px solid rgba(255, 255, 255, 0.2);
        /* Reduced border size */
        border-radius: 8px;
        /* Adjusted border-radius for a smaller button */
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: transform 0.2s, box-shadow 0.3s, border-color 0.3s;
        position: relative;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3), 0 0 6px rgba(98, 149, 132, 0.6);
        /* Adjusted box-shadow for a smaller button */
    }

    .gaming-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
        opacity: 0;
        transition: opacity 0.3s;
        border-radius: inherit;
    }

    .gaming-button:hover {
        background-color: #4a7a6c;
        transform: scale(1.05);
        /* Slightly reduced scaling */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4), 0 0 10px rgba(98, 149, 132, 0.8);
        /* Adjusted box-shadow for hover */
        border-color: rgba(255, 255, 255, 0.5);
    }

    .gaming-button:hover::before {
        opacity: 1;
        animation: shimmer 1.5s infinite;
    }

    .gaming-button:active {
        transform: scale(0.95);
        /* Slightly reduced scaling for active state */
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4), 0 0 6px rgba(98, 149, 132, 0.7);
        /* Adjusted box-shadow for active state */
    }


    /* Shimmer Animation */
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }


    /* Main Container Style */
    .navbar-cart {
        display: flex;
        align-items: center;
        gap: 0px;
        /* Space between items */
    }

    /* Wishlist Icon */
    .profile-icon {
        display: flex;
        align-items: center;
        position: relative;
        color: #333;
        text-decoration: none;
        font-size: 20px;
    }
    
    .wishlist a,
    .cart-items a{
        display: flex;
        align-items: center;
        position: relative;
        color: #333;
        text-decoration: none;
        font-size: 20px;
    }
    /* Badge Style */
    .total-items {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #0a58ca;
        color: #fff;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
    }

    /* Shopping Cart Dropdown */
    .cart-items .shopping-item {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        width: 250px;
        background: #fff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 10;
    }

    .cart-items:hover .shopping-item {
        display: block;
    }

    /* Profile Icon Styling */
    .profile-icon {
        padding: 8px;
        transition: color 0.3s;
    }

    .profile-icon:hover {
        color: #ce2929;
    }

    /* Additional Styling for Cart and Wishlist */
    .cart-items,
    .wishlist {
        position: relative;
    }
    </style>
    <header>
        <style>
        /* Style for the Login Button */
        .gaming-button {
            background-color: #629584;
            color: #fff;
            font-weight: bold;
            padding: 8px 16px;
            /* Reduced padding for a smaller button */
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* Reduced border size */
            border-radius: 8px;
            /* Adjusted border-radius for a smaller button */
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s, box-shadow 0.3s, border-color 0.3s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3), 0 0 6px rgba(98, 149, 132, 0.6);
            /* Adjusted box-shadow for a smaller button */
        }

        .gaming-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: inherit;
        }

        .gaming-button:hover {
            background-color: #4a7a6c;
            transform: scale(1.05);
            /* Slightly reduced scaling */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4), 0 0 10px rgba(98, 149, 132, 0.8);
            /* Adjusted box-shadow for hover */
            border-color: rgba(255, 255, 255, 0.5);
        }

        .gaming-button:hover::before {
            opacity: 1;
            animation: shimmer 1.5s infinite;
        }

        .gaming-button:active {
            transform: scale(0.95);
            /* Slightly reduced scaling for active state */
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4), 0 0 6px rgba(98, 149, 132, 0.7);
            /* Adjusted box-shadow for active state */
        }


        /* Shimmer Animation */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }


        /* Main Container Style */
        .navbar-cart {
            display: flex;
            align-items: center;
            gap: 15px;
            /* Space between items */
        }

        /* Wishlist Icon */
        .wishlist a,
        .cart-items a,
        .profile-icon {
            display: flex;
            align-items: center;
            position: relative;
            color: #333;
            text-decoration: none;
            font-size: 20px;
            border-radius: 100%;
        }

        /* Badge Style */
        .total-items {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #0a58ca;
            color: #fff;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Shopping Cart Dropdown */
        .cart-items .shopping-item {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            width: 250px;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 10;
        }

        .cart-items:hover .shopping-item {
            display: block;
        }

        /* Profile Icon Styling */
        .profile-icon {
            padding: 8px;
            /* transition: color 0.3s; */
        }

        .profile-icon:hover {
            color: #ce2929;
        }

        /* Additional Styling for Cart and Wishlist */
        .cart-items,
        .wishlist {
            position: relative;
        }

        #nav {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        #nav .nav-item a {
            white-space: nowrap;
        }

        #nav .sub-menu {
            position: absolute;
            display: none;
        }

        #nav .nav-item:hover .sub-menu {
            display: block;
        }

        .icon-text {
    /* display: block; */
    font-size: 10px;
    white-space: nowrap;
    margin-top: 0px; 
    /* cursor: pointer; */
}


        </style>
        <!-- Start Header Area -->
        <header class="header navbar-area">
            <!-- Start Header Middle -->
            <div class="header-middle">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Logo Section -->


                        <!-- Navigation Links Section -->
                        <div class="col-lg-5 col-md-6 col-12">
                            <nav class="navbar navbar-expand-lg">
                                <div class="col-lg-3 col-md-3 col-7">
                                    <a class="logo" href="index.php">
                                        <p class="logo">GamifyTech</p>
                                    </a>
                                </div>
                                <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <ul id="nav" class="navbar-nav mx-auto"style="
    padding-right: 70px;
    padding-left: 50px;
">
                                        <li class="nav-item">
                                            <a href="index.php" class="" aria-label="Toggle navigation">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="index.php#product_Categories"
                                                aria-label="Toggle navigation">Product Categories</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="index.php#new-arrival" aria-label="Toggle navigation">New
                                                Arrivals</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="index.php#trend_product" aria-label="Toggle navigation">Top Selling
                                                Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dd-menu collapsed" href="javascript:void(0)"
                                                data-bs-toggle="collapse" data-bs-target="#submenu-1-2"
                                                aria-controls="navbarSupportedContent" aria-expanded="false"
                                                aria-label="Toggle navigation">Pages</a>
                                            <ul class="sub-menu collapse" id="submenu-1-2">
                                                <li class="nav-item"><a href="productsPage.php">Product</a></li>
                                                <li class="nav-item"><a href="aboutus.php">About Us</a></li>
                                                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="col-lg-3 col-md-12 col-12">
                                        <div class="navbar-cart d-flex justify-content-end align-items-center"
                                            style="gap:10px;">

                                            <div class="wishlist text-center">
                                                <a href="wishList.php" class="icons" >
                                                    <i class="lni lni-heart"></i>
                                                </a>
                                            
                                            </div>

                                            <div class="cart-items text-center">
                                                <a href="cart.php" class="main-btn icons">
                                                    <i class="lni lni-cart"></i>
                                                </a>
                                            </div>

                                            <div class="profile-item text-center">
                                                <a href="profile.php" class="profile-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z" />
                                                    </svg>
                                                </a>
                                            </div>

                                            <?php if (isset($_SESSION['user_id'])): ?>
                                            <a href="?logout=true">Logout</a>
                                            <?php else: ?>
                                            <a href="../NextLevelTech/login/login.php">Login</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </nav>
                        </div>

                        <!-- Wishlist, Cart, and Profile Section -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Header Area -->




    </header>