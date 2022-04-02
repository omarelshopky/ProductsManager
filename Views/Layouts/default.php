<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title><?php echo $title; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/assets/style/GeneralStyle.css" rel="stylesheet">

    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body id="page-container">

    <main role="main" class="container col-md-11" id="content-wrap">

        <?php echo $content_for_layout; ?>

    </main>

    <footer id="footer">
        <hr class="m-1 mb-4">

        <p style="text-align: center;"> Scandiweb Test Assignment </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
