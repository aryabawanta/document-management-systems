<!-- CSS -->
    <link rel="stylesheet" href="<?= base_assets() ?>plugins/dropify/dist/css/dropify.min.css">
    <style type="text/css">
        .dropify-message p{
            text-align: center!important;
        }
        .modal {
          overflow-y:auto;
        }
    </style>
<!-- End CSS -->

<!-- Modals -->
    <form action="" id="upload_form" method="POST">
        <!-- Upload Modal -->
            <div class="modal fade bs-example-modal-lg" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content card-outline-info">
                        <div class="modal-header card-header text-white">
                            <h4 class="modal-title text-white" id="title_upload_modal">Document Upload</h4>
                            <button type="button text-white" class="close" data-dismiss="modal" aria-hidden="true"><span class="text-white">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="switch">
                                        <label>
                                            <input type="checkbox" checked="" id="is_upload_later"><span class="lever"></span> <span class="font-bold text-danger"> Upload Later</span></label>
                                    </div>
                                </div>
                            </div>
                            <div id="row_upload" class="row hidden m-b-20">
                                <div class="col-md-12">
                                    <div class="form-group m-b-0">
                                        <label for="upload_name"><small class="text-danger">File : Max 2Mb and only PDF</small></label>
                                        <div class="input-group">
                                            <input type="file" id="document" name="document" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="pdf" />
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_document">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            <hr />
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <div class="form-group m-b-0">
                                        <label for="upload_name">Deskripsi / Uraian / Nama </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-clipboard-text"></i>
                                                </span>
                                            </div>
                                            <textarea rows="3" class="form-control" name="upload_name" id="upload_name" required></textarea>
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_name">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success waves-effect text-left m-l-10" onClick="goToDetail()">Next <i class="ti-arrow-right"></i></button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        <!-- End Upload Modal -->

        <!-- Detail Modal -->
            <div class="modal fade bs-example-modal-lg" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="detail_modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content card-outline-info">
                        <div class="modal-header card-header text-white">
                            <h4 class="modal-title text-white" id="title_detail_modal">Document Detail</h4>
                            <button type="button text-white" class="close" data-dismiss="modal" aria-hidden="true"><span class="text-white">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row m-b-20">
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="upload_classification_id">Kode Klasifikasi <small>( tidak ada? <a href="<?= site_url('web/classification') ?>">Tambahkan</a> )</small></label>
                                        <div class="input-group">
                                            <div class="form-control" style="padding:0px!important;border:none!important">
                                                <?php echo form_dropdown('upload_classification_id', $variables['classifications'], '', 'id="upload_classification_id" class="select2 populate placeholder disable-enter" required style="border-radius:none!important;height:250px"')
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_classification_id">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="upload_workunit_id">Unit Kerja <small>( tidak ada? <a href="<?= $this->config->item('app_url').'/office/web/workunit' ?>">Tambahkan</a> )</small></label>
                                        <div class="input-group">
                                            <div class="form-control" style="padding:0px!important;border:none!important">
                                                <?php echo form_dropdown('upload_workunit_id', $variables['workunits'], '', 'id="upload_workunit_id" class="select2 populate placeholder disable-enter" required style="border-radius:none!important;height:250px"')
                                                ?>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_workunit_id">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            
                            <div class="row m-b-20">
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_box_code">Blok <small>( contoh: 01 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-border-all"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_block_code" name="upload_block_code" required="">
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_block_code">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_rack_code">Rak <small>( contoh: 01 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-square-inc"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_rack_code" name="upload_rack_code" required="">
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_rack_code">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_box_code">Box <small>( contoh: 001 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-archive"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_box_code" name="upload_box_code" required="">
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_box_code">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_envelope_code">Sampul <small>( contoh: 001 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-folder-multiple"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_envelope_code" name="upload_envelope_code" required="">
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_envelope_code">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            <div class="row m-b-20">
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_archive_number">No Arsip <small>( contoh: 01 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-file-xml"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_archive_number" name="upload_archive_number" required>
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_archive_number">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group m-b-0">
                                        <label for="upload_year">Tahun <small>( contoh: 2019 )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-calendar-clock"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_year" name="upload_year" required="">
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_year">
                                        *cant be empty
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="upload_condition">Kondisi <small>( contoh: Baik )</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-emoticon"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_condition" name="upload_condition" required="">
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_condition">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            <hr />
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary pull-xs-down-left pull-xs-up-left" onClick="generateCode()" style="margin-right: 5px">
                                        <i class="mdi mdi-code-not-equal-variant"></i> Generate Code
                                    </button>
                                </div>
                            </div>
                            <div class="row m-b-20">
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="upload_folder_name">Folder / Map Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-folder"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_folder_name" name="upload_folder_name" required readonly="readonly">
                                        </div>
                                        <small class="text-danger form-control-feedback hidden" id="error_upload_folder_name">
                                            *cant be empty
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="upload_location_code">Lokasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-map-marker"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_location_code" name="upload_location_code" required readonly="readonly">
                                            
                                        </div>
                                    </div>
                                    <small class="text-danger form-control-feedback hidden" id="error_upload_location_code">
                                        *cant be empty
                                    </small>
                                </div>
                                
                            </div>
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <div class="form-group m-b-0">
                                        <label for="upload_file_name">Document File Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-file-document"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control disable-enter" id="upload_file_name" name="upload_file_name" required readonly="readonly">                                            
                                        </div>
                                    </div>
                                    <small class="help-block text-danger hidden" id="error_upload_file_name">
                                        *cant be empty
                                    </small>
                                </div>
                            </div>
                            
                            <hr />
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-success pull-xs-down-left pull-xs-up-left" data-dismiss="modal" onClick="showModal('upload')" style="margin-right: 5px">
                                        <i class="ti-arrow-left"></i> Previous
                                    </button>
                                    
                                    <button type="button" class="btn btn-success pull-xs-down-right pull-xs-up-right" onClick="goSubmitUpload()" style="margin-right: 5px">
                                        <i class="mdi mdi-check"></i> Submit 
                                    </button>
                                </div>
                                    
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        <!-- End Detail Modal -->
    </form>
<!-- End Modals -->

<!-- Script -->
    <script src="<?= base_assets() ?>plugins/dropify/dist/js/dropify.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.disable-enter').on('keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) { 
                    e.preventDefault();
                    goSubmitUpload();
                    return false;
                }
            });

            $(".select2").select2();
            $("#is_upload_later").on('change',function(){
                if (document.getElementById('is_upload_later').checked){
                    $("#document").removeAttr("required");
                    $("#row_upload").addClass("hidden");
                } else{
                    $("#document").attr("required", "true");
                    $("#row_upload").removeClass("hidden");
                }
            });

            $("#upload_classification_id").select2({
                placeholder:"Pilih Klasifikasi . . .",
                width:"100%",
                height:"150px",
                dropdownParent: $("#detail_modal")
            });

            $("#upload_workunit_id").select2({
                placeholder:"Pilih Unit Kerja Dokumen . . .",
                width:"100%",
                height:"150px",
                dropdownParent: $("#detail_modal")
            });


            /* Dropify */
                // Basic
                $('.dropify').dropify();

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element) {
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element) {
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element) {
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                });
            /* End Dropify */
        });


        function goToDetail(){
            var validation = true;

            if (!document.getElementById('is_upload_later').checked){
                $("#error_upload_document").addClass("hidden");
                if (document.getElementById('document').value==''){
                    $("#error_upload_document").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_name").addClass("hidden");
            if (document.getElementById('upload_name').value==''){
                $("#error_upload_name").removeClass("hidden");
                validation = false;
            }

            if (validation){
                $('#upload_modal').modal('hide');
                showModal('detail');
            }
        }

        function generateCode(){
            if (validationDetail(['upload_folder_name','upload_file_name', 'upload_location_code', 'upload_condition','upload_workunit_id'])){
                var classification_id = document.getElementById("upload_classification_id").value;
                var classification = '';

                $.ajax({
                    url : '<?= site_url('web/ajax/getClassification') ?>/'+classification_id,        
                    type: "POST",
                    data: {},
                    success: function(response){
                        if (response==false){
                            classification = '';
                        } else {
                            classification = String(response);
                        }
                    }
                }).then(function(){
                    var box = document.getElementById("upload_box_code").value;
                    var envelope = document.getElementById("upload_envelope_code").value;
                    var year = document.getElementById("upload_year").value;
                    var block = document.getElementById("upload_block_code").value;
                    var rack = document.getElementById("upload_rack_code").value;
                    var archive_number = document.getElementById("upload_archive_number").value;

                    // folder name
                    document.getElementById("upload_folder_name").value = classification+'_'+box+'_'+envelope+'_'+year;

                    // document name
                    document.getElementById("upload_file_name").value = classification+"_"+year+"_"+block+"_"+rack+"_"+box+"_"+envelope+"_"+archive_number;

                    //location 
                    
                    document.getElementById("upload_location_code").value = "B."+block+".R."+rack+"."+box;

                    return true;    
                });
            }
            return false;
        }

        function validationDetail(without=[]){
            console.log(without);
            var validation = true;

            $("#error_upload_classification_id").addClass("hidden");
            if (without.indexOf('upload_classification_id')==-1){
                if (document.getElementById('upload_classification_id').value==''){
                    $("#error_upload_classification_id").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_workunit_id").addClass("hidden");
            if (without.indexOf('upload_workunit_id')==-1){
                if (document.getElementById('upload_workunit_id').value==''){
                    $("#error_upload_workunit_id").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_archive_number").addClass("hidden");
            if (without.indexOf('upload_archive_number')==-1){
                if (document.getElementById('upload_archive_number').value==''){
                    $("#error_upload_archive_number").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_year").addClass("hidden");
            if (without.indexOf('upload_year')==-1){
                if (document.getElementById('upload_year').value==''){
                    $("#error_upload_year").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_location_code").addClass("hidden");
            if (without.indexOf('upload_location_code')==-1){
                if (document.getElementById('upload_location_code').value==''){
                    $("#error_upload_location_code").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_block_code").addClass("hidden");
            if (without.indexOf('upload_block_code')==-1){
                if (document.getElementById('upload_block_code').value==''){
                    $("#error_upload_block_code").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_rack_code").addClass("hidden");
            if (without.indexOf('upload_rack_code')==-1){
                if (document.getElementById('upload_rack_code').value==''){
                    $("#error_upload_rack_code").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_box_code").addClass("hidden");
            if (without.indexOf('upload_box_code')==-1){
                if (document.getElementById('upload_box_code').value==''){
                    $("#error_upload_box_code").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_envelope_code").addClass("hidden");
            if (without.indexOf('upload_envelope_code')==-1){
                if (document.getElementById('upload_envelope_code').value==''){
                    $("#error_upload_envelope_code").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_condition").addClass("hidden");
            if (without.indexOf('upload_condition')==-1){
                if (document.getElementById('upload_condition').value==''){
                    $("#error_upload_condition").removeClass("hidden");
                    validation = false;
                }
            }

            $("#error_upload_folder_name").addClass("hidden");
            if (without.indexOf('upload_folder_name')==-1){
                if (document.getElementById('upload_folder_name').value==''){
                    $("#error_upload_folder_name").removeClass("hidden");
                    validation = false;
                }
            }
            
            $("#error_upload_file_name").addClass("hidden");
            if (without.indexOf('upload_file_name')==-1){
                if (document.getElementById('upload_file_name').value==''){
                    $("#error_upload_file_name").removeClass("hidden");
                    validation = false;
                }
            }
            return validation;
        }

        function goSubmitUpload(){
            if (validationDetail()){
                generateCode();
                // $("#upload_form").submit();
                // swal("Sorry!", "Submit Document Feature is not ready yet", "error");
                $("#detail_modal").block({
                    message: '<i class="fas fa-spin fa-sync text-white"></i>',
                    fadeIn: 1000,
                    // timeout: 2000, //unblock after 2 seconds
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.5,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        color: '#333',
                        backgroundColor: 'transparent',
                        'z-index' : 9999
                    },
                    onBlock: function() {
                        $.ajax({
                            url : '<?= site_url('web/document/ajaxCreate') ?>',        
                            type: "POST",
                            data: {'classification_id' : document.getElementById('upload_classification_id').value,
                                    'workunit_id' : document.getElementById('upload_workunit_id').value,
                                    'location_code' : document.getElementById('upload_location_code').value,
                                    'file_name' : document.getElementById('upload_file_name').value,
                                    'folder_name' : document.getElementById('upload_folder_name').value,
                                    'archive_number' : document.getElementById('upload_archive_number').value,
                                    'name' : document.getElementById('upload_name').value,
                                    'condition' : document.getElementById('upload_condition').value,
                                    'year' : document.getElementById('upload_year').value,
                                    'envelope_code' : document.getElementById('upload_envelope_code').value,
                                    'box_code' : document.getElementById('upload_box_code').value,
                                    'block_code' : document.getElementById('upload_block_code').value,
                                    'rack_code' : document.getElementById('upload_rack_code').value },
                            success: function(response){
                                console.log(response);
                                if (response==false){
                                    $("#detail_modal").unblock();
                                    var message = swal("Error!","Please check your data again. Maybe 'Document File Name' already exist!","error");
                                } else {
                                    $("#detail_modal").unblock();
                                    var message = swal("Added!","Successfully added new document.","success");
                                    message.then(function(){
                                        location.href = "<?= site_url() ?>";
                                    });
                                }
                                
                            }
                        });
                    }
                });
            }
        }
        
    </script>
<!-- End Script -->