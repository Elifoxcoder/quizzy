<?php
include ('../php/variables.php');
session_start();

$name = $_SESSION['userRow']['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php require ('../php/head.php'); ?>

    <style>

        @font-face {
            font-family: "Poppins";
            src: url("../assets/Poppins/poppins.otf");
        }

        * {
            transition: 200ms;
            font-weight: 500;
            margin: 0;
            padding: 0;
            font-family: "Poppins", Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            display: flex;
            background-color: var(--white);
        }

        .nav {
            display: flex;
            flex-direction: column;
            background-color: #222;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            height: 100vh;
            color: #fff;
        }

        .nav-header {
            padding: 20px;
        }

        .nav-list {
            list-style: none;
            padding: 20px;
            display: flex;
            flex-direction: column;
            padding-top: 0px;
        }

        .nav-list a {
            padding: 10px;
            transition: 200ms;
            border-radius: 10px;
        }

        .nav a:hover {
            background: var(--dark_grey);
        }


        .list-item-link {
            text-decoration: none;
            color: #fff;
        }


        main {
            /* background-color: var(--white); */
            flex: 1;
            height: 100vh;
            padding: 50px;
            overflow: scroll;
        }

        .container {
            display: flex;
            height: calc(100vh - 100px);
            justify-content: center;
            align-items: center;
        }


        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            scale: 15;
        }


        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }


        .slider {
            position: absolute;
            cursor: pointer;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            height: 100%;
            width: auto;
            border-radius: 34px;
        }


        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            transition-timing-function: cubic-bezier(0.785, 0.135, 0.15, 0.865);
        }


        input:checked+.slider {
            background-color: #4caf50;
        }


        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body id="navigation">
    <?php require "../php/nav.php" ?>
    <main>
           <div class="container">
                <label class="switch">
                    <input id="button" type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>

        <!-- <button id="button">Click me</button> -->
    </main>

    <script>

    </script>
</body>

</html>