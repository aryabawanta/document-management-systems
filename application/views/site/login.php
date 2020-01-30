<?php $this->template->setStylesheet(base_url() . 'assets/css/login.css'); ?>
<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="text-center">
                <?= img(array('src' => 'assets/img/logo.png', 'class' => 'col-sm-6  col-sm-offset-3', 'style' => 'max-width:60%')) ?>
            </div>
            <div class="clearfix"></div>
            <div>
                <?php $flash = SessionManagerWeb::getFlash();
                    echo $flash;
                    if($flash!=null){
                        echo $flash;
                        echo "abc";
                    }
                ?>
            </div>
            <div class="well">
                <?= form_open() ?>
                <?= form_input('username', set_value('username'), 'class="form-control" placeholder="Username" required autofocus') ?>
                <?= form_password('password', set_value('password'), 'class="form-control" placeholder="Password" required') ?>
                <button class="btn btn-material-light-blue-800 pull-right" type="submit">LOGIN </button>
                <div class="clearfix"></div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
