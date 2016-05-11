<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
        <meta http-equiv="Content-Language" content="pt-br">
        <meta name="description" content="Rename.com">
        <meta name="author" content="Rename.com.">
        <title><?php echo $title ?></title>
        <?php echo $this->Html->css('/css/bootstrap.css'); ?>
        <?php echo $this->Html->css('/font-awesome/css/font-awesome.css'); ?>
        <?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Open+Sans:400,300'); ?>
    </head>
    <body style="background: #EEEEEE;">
        <br /><br />
        <div style="margin: 0 auto; width: 600px; background: #fff; text-align: center;">
            
            <div class="text-center" style="padding: 30px; font-size: 15px;">
                <?php echo $this->conteudo; ?>
            </div>
            <?php echo $this->Html->script('/js/jquery.js'); ?>
            <?php echo $this->Html->script('/js/bootstrap.js'); ?>
        </div>
        <br />
        <div style="height: 50px; color: #273441; text-align: center;">
            Esta é uma mensagem automática, favor não responder este e-mail.
        </div>
        <br /><br />
    </body>
</html>
