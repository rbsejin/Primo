<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- bootstrap JS -->
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    <!-- bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            height: 500px;
            background-color: aqua;
        }

        .content {
            display: flex;
            flex-grow: 1;
        }

        .main_title {
            display: flex;
            flex-direction: row;
        }

        ul {
            list-style: none;
        }

        ul.menu {
            list-style: none;
            margin: 0px;
            padding: 0px;
        }

        li.item {
            margin: 0px;
            margin-right: 15px;
            padding: 0px;
            float: left;
        }

        table {
            clear: left;
        }

        nav {
            flex-basis: 150px;

            background-color: tan;
        }

        main {
            flex-grow: 1;
            background-color: antiquewhite;
        }

        header {
            background-color: blue;
        }

        footer {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>관리자 페이지</h1>
        </header>
        <section class="content">