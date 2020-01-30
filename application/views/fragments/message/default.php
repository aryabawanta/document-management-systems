<?php
if (SessionManager::existFlashMessage()) {
    list($success, $message) = SessionManager::getFlashMessage();
    $alert = ($success) ? 'alert-success' : 'alert-danger';
    ?>
    <div class="message-autohide">
        <div class="alert alert-dismissable <?= $alert ?>" >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?= $message ?>
        </div>
    </div>
<?php } ?>