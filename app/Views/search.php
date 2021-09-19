<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijotons - Recherche</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!--- fonteawesome -->
    <script src="https:use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- css -->
    <link href="<?= base_url('public/assets/css/style.css') ?>" rel="stylesheet" type="text/css" media="all" />
    <link rel="shortcut icon" href="<?= base_url('public/images/toque.ico') ?>" type="image/x-icon" />

    <style>
        .row {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .flipper {
            position: absolute;
            top: 33%;
            left: 24%;
            margin-bottom: 50px;
            display: none;
            z-index: 0;
        }

        .flipper {
            perspective: 600px;
            -webkit-perspective: 600px;
            -moz-perspective: 600px;

            -webkit-transform-origin: 100% center;
            -moz-transform-origin: 100% center;
            -ms-transform-origin: 100% center;
            transform-origin: 100% center;
        }

        .front-card,
        .back-card {
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            transform-style: preserve-3d;

            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;

            -o-transition: transform .6s ease-in-out;
            -moz-transition: transform .6s ease-in-out;
            -webkit-transition: transform .6s ease-in-out;
            transition: transform .6s ease-in-out;

            position: absolute;
            top: 0;
            left: 0;
        }

        .front-card {
            z-index: 2;
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            transform: rotateY(0deg);
        }

        .flipper.flip .front-card {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }

        .back-card {
            -webkit-transform: rotateY(-180deg);
            -moz-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
        }

        .flipper.flip .back-card {
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            transform: rotateY(0deg);
        }

        .card {
            width: 100%;
            min-height: 100vh;
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 2px;
            background-clip: padding-box;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            margin-bottom: 50px;
        }

        .card span.card-title {
            color: #fff;
            font-size: 24px;
            font-weight: 300;
            text-transform: uppercase;
        }

        .card .card-image {
            position: relative;
            overflow: hidden;
        }

        .card .card-image .header-front,
        .card .card-image .header-back {
            border-radius: 2px 2px 0 0;
            background-clip: padding-box;
            position: relative;
            z-index: -1;
            width: 120%;
            height: 330px;
        }

        .card .card-image span.card-title {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 66px;
        }

        .card .card-content {
            padding: 16px;
            border-radius: 0 0 2px 2px;
            background-clip: padding-box;
            box-sizing: border-box;
            text-align: center;
        }

        .card .card-content p {
            margin: 0;
            color: inherit;
        }

        .card .card-content span.card-title {
            line-height: 48px;
        }
    </style>
</head>

<body>

    <div class="search_container">
        <form class="search_recipe_form">
            <h5 class="search_form_title">Entrer un lien de recette Marmiton</h5>
            <input type="text" id="url_link" />
            <button type="button" id="submit_recipe_search">Rechercher</button>
        </form>
    </div>

    <div class="row anchor_recipe_card" style="height:132vh">
        <div class="flipper col-md-6 col-md-offset-3 flip_card">
            <div class="front-card card">
                <div class="card-image">
                    <div class="header-front"></div>
                    <span class=" card-title"></span>
                </div>
                <h5 style="text-align:center">Les ingrédients</h5>
                <div class="card-content content_ingredients">
                </div>
                <span class="message_flip">Cliquer sur la carte pour afficher le verso</span>

            </div>
            <div class="back-card card">

                <div class="card-content content_steps">

                </div>
                <span class="message_flip">Cliquer sur la carte pour afficher le recto</span>
            </div>
        </div>
    </div>
    <br>
    <div class="options_search">
        <button type="button" class="options_btn" id="add_collection">Ajouter à ma collection</button>&nbsp;&nbsp;
        <button type="button" class="options_btn" id="new_search">Nouvelle recherche</button>
    </div>





    <script src="<?= base_url('public/assets/js/search.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('.flipper').click(function() {
                $(this).toggleClass('flip');
            });
        });
    </script>
</body>

</html>