<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex no-block col-md-7">
                        <h4 class="card-title"><?= $title ?></h4>
                    </div>
                    <div class="col-md-5 text-align-sm-up-right">
                        <?php
                            foreach ($buttons as $button) {
                            ?>
                                <button class="btn btn-<?= $button['type'] ?> " style="margin-right: 20px;margin-bottom: 10px;" onClick="<?= $button['click'] ?>">
                                    <i class="fa fa-<?= $button['icon'] ?>"></i>
                                    <?= $button['label']?>
                                </button>
                            <?php
                            }
                        ?>
                    </div>
                </div>
                
                <hr>
                <form id="migrate_form" action="<?= site_url("web/migration/migrate/".$type) ?>" method="POST" enctype="multipart/form-data">
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            <div class="form-group m-b-0">
                                <label for="upload_name"><small class="text-danger">File : Max 2Mb, Format : .xls dan .xlsx</small></label>
                                <div class="input-group">
                                    <input type="file" id="file" name="file" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="xls xlsx" required="required" />
                                </div>
                            </div>
                            <small class="text-danger form-control-feedback hidden" id="error_file">
                                *cant be empty
                            </small>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12  text-align-sm-up-right">
                            <button type="button" onClick="goSubmit()" class="btn btn-success">
                                <i class="mdi mdi-check"></i>
                                Submit Now
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function goSubmit(){
        var validation = true;

        $("#error_file").addClass("hidden");
        if (document.getElementById('file').value==''){
            $("#error_file").removeClass("hidden");
            validation = false;
        }

        if (validation){
            $("#migrate_form").submit();
        }
    }
</script>
