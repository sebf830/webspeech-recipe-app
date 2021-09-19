<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>speech</title>
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
</head>

<body>

    <h1 class="error">
        L'outil de reconaissance n'est pas supporté sur votre navigateur, essayez d'utiliser CHROME ou FIREFOX
    </h1>

    <button class="start">
        commencer &nbsp;<i class="fa fa-comments"></i>
    </button>

    <!-- 
    <div id="displayResult" class="displayResult">
        <h3 class="title_result"></h3>
        <br>
        <div class="img_result"></div>
        <div class="ingredient_section">
            <h4 class="title_ingrédient" style="text-align:center;"></h4>
            <p id="ingrédients_result"></p>
        </div>
        <div class="recipe_section">
            <h4 style="text-align:center;margin-bottom:30px;">Détail de la recette</h4>
            <p id="recipe_result"></p>
        </div>
    </div>

    <div id="displayCategories" class="displayCategories">

        <h3 class="title_category" style="text-align:center"></h3>
        <div class="item">
        </div>
    </div>

    <div class="container">
        <!-- Recognized voice -->
    <div class="block_command" style="text-align:center;width:60%;">
        <h5 class="title_command ">Commandes vocales disponibles</h5>
        <ul id="list_commands"> </ul>
    </div>
    <div style="text-align:center">
        <i class="fa fa-microphone fa-2x"></i>
        <h3 class="command"></h3>
    </div>
    </div>

    <script src="<?= base_url('public/assets/js/app.js') ?>"> </script>
</body>


</html>