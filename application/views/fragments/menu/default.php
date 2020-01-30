<div id="drawerExample" class="drawer dw-xs-10 dw-sm-6 dw-md-4 fold" aria-labelledby="drawerExample">
    <div class="drawer-controls">
        <a href="#drawerExample" data-toggle="drawer" href="#drawerExample" aria-foldedopen="false" aria-controls="drawerExample" class="btn btn-primary btn-sm">Menu</a>
    </div>
    <div class="drawer-contents">
        <div class="drawer-heading">
            <h4 class="drawer-title"><strong>SIGAP</strong></h4>
        </div>
        <div class="drawer-body">
            <div class="list-group" style="margin-bottom: 0">
                <div class="list-group-item padding-0 margin-10">
                    <div class="row-picture">
                        <?php if (isset($userLoggedIn['photo'])) { ?>
                            <img class="circle" src="<?= $userLoggedIn['photo']['thumb']['link'] ?>">
                        <?php } else { ?>
                            <i class="mdi-action-account-circle"></i>
                        <?php } ?>
                    </div>
                    <div class="row-content">
                        <?= $userLoggedIn['name'] ?>
                        <p>
                            <span class="text-muted"><?= $userLoggedIn['email'] ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="drawer-nav">
            <li role="presentation" class="active"><a href="#"><i class="mdi-action-home"></i> Home</a></li>
            <li role="presentation"><a href="#">Profile</a></li>
            <li role="presentation"><a href="#">Messages</a></li>
        </ul>
    </div>
</div>