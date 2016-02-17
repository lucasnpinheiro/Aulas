<div class="row">
    <div class="col-xs-12">
        <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
            <h4>Uma exceção não capturada foi encontrada</h4>
            <p>Tipo: <?php echo get_class($exception); ?></p>
            <p>Mensagem: <?php echo $message; ?></p>
            <p>Arquivo: <?php echo $exception->getFile(); ?></p>
            <p>Linha: <?php echo $exception->getLine(); ?></p>
            <p>Backtrace:</p>
            <?php
            if (!empty($exception->getTrace())) {
                foreach ($exception->getTrace() as $error) {
                    ?>
                    <p style="margin-left:10px">
                        File: <?php echo $error['file']; ?><br />
                        Line: <?php echo $error['line']; ?><br />
                        Function: <?php echo $error['function']; ?>
                    </p>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>