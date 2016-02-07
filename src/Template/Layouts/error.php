<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="https://getbootstrap.com/favicon.ico">

        <title>Error</title>

        <?php echo $this->Html->css('/css/bootstrap.css'); ?>
        <?php echo $this->Html->css('/css/ie10-viewport-bug-workaround.css'); ?>
        <?php echo $this->Html->css('/css/Aulas.css'); ?>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $this->conteudo; ?>
                </div>
            </div>
        </div>
        <?php echo $this->Html->script('js/jquery.js'); ?>
        <?php echo $this->Html->script('js/bootstrap.js'); ?>
    </body>
</html>
