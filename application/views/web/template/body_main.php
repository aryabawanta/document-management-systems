<body class="fix-header fix-sidebar card-no-border">    
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
    <!---->
    <div id="main-wrapper">
        <?= $header ?>
        <?= $sidebar ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid p-t-20">
            <!-- <div class="container-fluid"> -->
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <?php if (false) { ?>
                    <div class="row page-titles">
                        <div class="col-12 align-self-center">
                            <h3 class="text-themecolor"><?= $title ?></h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $class_name ?></a></li>
                                <li class="breadcrumb-item active"><?= $method_name ?></li>
                            </ol>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <?php if (isset($srvok)) { ?>
                            <div class="alert alert-<?php echo ($srvok ? 'success' : 'danger') ?> alert-dismissable" >
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $srvmsg ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?= $body ?>
                <!-- Modals -->
                    <?php include VIEWPATH."web/_upload_modal.php"; ?>
                <!-- End Modals -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2019 Codelogic </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
    </div>
</body>
<div class="loadings" style="display: none;"><i class="fa fa fa-circle-o-notch fa-spin" style="font-size:40px"></i></div>
<script type="text/javascript">
    function back() {
        parent.history.back();
        return false;
    }
    
    $(document).ready(function() {
        $("form").submit(function () {
            $('.loadings').show();
            return true;
        });
    });

    function showModal(modal_id='action'){
        $('#'+modal_id+'_modal').modal('show');
    }
</script>