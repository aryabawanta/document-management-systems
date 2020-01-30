<script type="text/javascript">
    function goClearFilter(){
        location.href = "<?= site_url('web/document/clearFilter') ?>";
    }

    function goFilter(){
        $("#modal_filter").modal("show");

        // setting action and method
        document.getElementById('form_filter').action = "<?= site_url('web/document')?>";
        document.getElementById('form_filter').method = "POST";

        // setting isi form
        document.getElementById("modal_filter_body").innerHTML = 
                        `<div class="col-sm-12 m-t-30">
                            <div class="row bord-bottom">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="mdi mdi-file"></i>
                                            </span>
                                        </div>
                                        <?php echo form_input(array('name' => 'filter_name', 'value' => $filter['name'], 'class' => 'form-control input-sm filter', 'id' => 'filter_name', 'placeholder'=>'Document Name...', 'autocomplete'=>'off')) ?>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_name')"><i class="mdi mdi-close"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="row m-b-20 m-t-30">
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="filter_classification_id" class="hidden-mobile">Kode Klasifikasi </label>
                                        <div class="input-group">
                                            <div class="form-control" style="padding:0px!important;border:none!important">
                                                <?php echo form_dropdown('filter_classification_id', $variables['classifications'], $filter['classification_id'], 'id="filter_classification_id" class="select2 populate placeholder" style="border-radius:none!important;height:250px"')
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-0">
                                        <label for="filter_workunit_id" class="hidden-mobile">Unit Kerja </label>
                                        <div class="input-group">
                                            <div class="form-control" style="padding:0px!important;border:none!important">
                                                <?php echo form_dropdown('filter_workunit_id', $variables['workunits'], $filter['workunit_id'], 'id="filter_workunit_id" class="select2 populate placeholder" style="border-radius:none!important;height:250px"')
                                                ?>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row m-b-20 m-t-30">
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_year" class="hidden-mobile hidden">Tahun </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-calendar-clock"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_year" name="filter_year" placeholder="Tahun..." value="<?= $filter['year'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_year')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_archive_number" class="hidden-mobile hidden">No Arsip </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-file-xml"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_archive_number" name="filter_archive_number" placeholder="No Arsip..." value="<?= $filter['archive_number'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_archive_number')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_envelope_code" class="hidden-mobile hidden">Sampul </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-folder-multiple"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_envelope_code" name="filter_envelope_code" placeholder="Sampul..." value="<?= $filter['envelope_code'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_envelope_code')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-20 ">
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_box_code" class="hidden-mobile hidden">Box </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-archive"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_box_code" name="filter_box_code" placeholder="Box..." value="<?= $filter['box_code'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_box_code')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_rack_code" class="hidden-xs-down hidden">Rak</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-square-inc"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_rack_code" name="filter_rack_code" placeholder="Rak..." value="<?= $filter['rack_code'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_rack_code')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 m-b-10">
                                    <div class="form-group m-b-0">
                                        <label for="filter_block_code" class="hidden-xs-down hidden">Blok</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-border-all"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control filter" id="filter_block_code" name="filter_block_code" placeholder="Blok..." value="<?= $filter['block_code'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger" type="button" onclick="resetFilter('filter_block_code')"><i class="mdi mdi-close"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

        $(".select2").select2();

        $("#filter_classification_id").select2({
            placeholder:"Pilih Klasifikasi . . .",
            width:"100%",
            height:"150px",
            dropdownParent: $("#modal_filter"),
            allowClear:true
        });

        $("#filter_workunit_id").select2({
            placeholder:"Pilih Unit Kerja Dokumen . . .",
            width:"100%",
            height:"150px",
            dropdownParent: $("#modal_filter"),
            allowClear:true
        });
    }

    function resetFilter(id){
        document.getElementById(id).value='';
    }
</script>