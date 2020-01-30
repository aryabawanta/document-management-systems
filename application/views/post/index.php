<div class="container">
    <div class="row grid" id="post-content">
        <?php foreach ($posts as $post) { ?>
            <div class="col-sm-4 grid-item">
                <div class="well" style="padding: 10px 0">
                    <div class="list-group" style="margin-bottom: 0">
                        <div class="list-group-item padding-0 margin-10">
                            <div class="row-picture">
                                <?php if (isset($post['user']['photo'])) { ?>
                                    <img class="circle" src="<?= $post['user']['photo']['thumb']['link'] ?>">
                                <?php } else { ?>
                                    <i class="mdi-action-account-circle"></i>
                                <?php } ?>
                            </div>
                            <div class="row-content">
                                <?= Util::getHeaderName($post) ?>
                                <p><span class="text-muted text-size-10"><?= Util::countdown($post['createdAt']) ?></span></p>
                            </div>
                        </div>
                        <?php if (!empty($post['description'])) { ?>
                            <div class="list-group-item padding-0 margin-10">
                                <p><?= $post['description'] ?></p>
                            </div>
                        <?php } ?>
                        <?php if (!empty($post['link'])) { ?>
                            <div class="list-group-item padding-0 margin-10">
                                <p><?= $post['link'] ?></p>
                            </div>
                        <?php } ?>
                        <?php if (!empty($post['file'])) { ?>
                            <div class="list-group-item padding-0 margin-10">
                                <p><?= anchor($post['file']['link'], $post['file']['name']) ?></p>
                            </div>
                        <?php } ?>
                        <?php if (!empty($post['image'])) { ?>
                            <div class="list-group-item padding-0">
                                <img class="width-100" src="<?= $post['image']['medium']['link'] ?>">
                            </div>
                        <?php } ?>
                        <?= anchor('post/detail/' . $post['id'], '<i class="mdi-communication-chat"></i> Komentar', 'class="pull-right margin-10"') ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center"><a href="#" id="load-more">Load more</a></div>
    </div>
</div>
<?php
$this->template->addJavascript('
    $(document).ready(function(){
        $("#load-more").click(function(){
            
        })
    })');
