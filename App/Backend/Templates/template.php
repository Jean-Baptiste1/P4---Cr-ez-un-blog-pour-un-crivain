<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>
            Mon Roman Billet simple pour l'Alaska.
        </title>
        <link href="Web/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    </head>
        <header>
            <?php require('App/Backend/header.php'); ?>
        </header>

    <body>
        <?= $content ?>
    </body>
    <?php require('App/Frontend/footer.php'); ?>

</html>