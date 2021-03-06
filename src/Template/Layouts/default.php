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

        <title>Fixed Top Navbar Example for Bootstrap</title>

        <?php echo $this->Html->css('/css/font-awesome.min.css'); ?>
        <?php echo $this->Html->css('/css/bootstrap.css'); ?>
        <?php echo $this->Html->css('/css/ie10-viewport-bug-workaround.css'); ?>
        <?php echo $this->Html->css('/css/navbar-fixed-top.css'); ?>
        <?php echo $this->Html->css('/css/Aulas.css'); ?>


        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><?php echo $this->Html->script('https://getbootstrap.com/assets/js/ie8-responsive-file-warning.js'); ?><![endif]-->
        <?php echo $this->Html->script('https://getbootstrap.com/assets/js/ie-emulation-modes-warning.js'); ?>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <?php echo $this->Html->script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'); ?>
        <?php echo $this->Html->script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js'); ?>
        <![endif]-->
    </head>

    <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Minha Loja Virtual</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><?php echo $this->Html->link('Home', ['controller' => 'Home', 'action' => 'index']) ?></li>
                        <li><?php echo $this->Html->link('Produtos', ['controller' => 'Produtos', 'action' => 'pesquisar']) ?></li>
                        <li><?php echo $this->Html->link('Carrinho', ['controller' => 'Carrinho', 'action' => 'index']) ?></li>
                        <li><?php echo $this->Html->link('Contato', ['controller' => 'Home', 'action' => 'contato']) ?></li>
                        

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><?php echo $this->Html->link('Área do Cliente', ['controller' => 'Clientes', 'action' => 'login'], ['target' => '_blank']) ?></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <?php echo $this->flash(); ?> 
        <?php echo $this->conteudo; ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $this->Html->script('/js/jquery.js'); ?>
        <?php echo $this->Html->script('/js/bootstrap.js'); ?>
        <?php echo $this->Html->script('/js/acoes.js'); ?>
    </body>
</html>
