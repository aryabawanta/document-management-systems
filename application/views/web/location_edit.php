<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <h2><?= $title ?></h2>
                    </div>
                    <div class="col-md-7 text-align-sm-up-right">
                        <button class="btn btn-secondary" style="margin-right: 20px;margin-bottom: 10px;" onClick="javascript:goBack()">
                            <i class="fa fa-chevron-left"></i>
                            Kembali
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?php echo form_open_multipart($path . $class . '/' . (isset($id) ? 'update/' . $id : 'create'), array('id' => 'form_data')) ?>
                            <div class="col-sm-8">
                                <div class="row form-group">
                                    <label class="col-sm-4 col-form-label hidden-xs-down">Location Code</label>
                                    <small class="m-l-15 hidden-sm-up">Location ID</small>
                                    <div class="col-sm-8">
                                        <?php echo form_input(array('name' => 'code', 'value' => $data['code'], 'class' => 'form-control', 'id' => 'code', 'required' => 'true')) ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-4 col-form-label hidden-xs-down">Name</label>
                                    <small class="m-l-15 hidden-sm-up">Name</small>
                                    <div class="col-sm-8">
                                        <?php echo form_input(array('name' => 'name', 'value' => $data['name'], 'class' => 'form-control', 'id' => 'name', 'required' => 'true')) ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-4 col-form-label hidden-xs-down">
                                        Parent
                                        <a class="mytooltip" href="javascript:void(0)"> 
                                            <i class="mdi mdi-information-outline"></i>
                                            <span class="tooltip-content5">
                                                <span class="tooltip-text3">
                                                    <span class="tooltip-inner2">Lokasi diatasnya sesuai dengan Struktur Lokasi
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </label>
                                    <small class="m-l-15 hidden-sm-up">
                                        Parent
                                        <a class="mytooltip" href="javascript:void(0)"> 
                                            <i class="mdi mdi-information-outline"></i>
                                            <span class="tooltip-content5">
                                                <span class="tooltip-text3">
                                                    <span class="tooltip-inner2">Lokasi diatasnya sesuai dengan Struktur Lokasi
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </small>
                                    <div class="col-sm-8">
                                        <?php echo form_dropdown('parent', $variables['locations'], $data['parent'], 'id="parent" class="form-control select2" required style="border-radius:4px!important;"')
                                        ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-4 col-form-label hidden-xs-down">
                                        Gunakan Kode? 
                                        <a class="mytooltip" href="javascript:void(0)"> 
                                            <i class="mdi mdi-information-outline"></i>
                                            <span class="tooltip-content5">
                                                <span class="tooltip-text3">
                                                    <span class="tooltip-inner2">Menggunakan Kode untuk Identifikasi Lokasi Dokumen
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </label>
                                    <small class="m-l-15 hidden-sm-up">
                                        Gunakan Kode? 
                                        <a class="mytooltip" href="javascript:void(0)"> 
                                            <i class="mdi mdi-information-outline"></i>
                                            <span class="tooltip-content5">
                                                <span class="tooltip-text3">
                                                    <span class="tooltip-inner2">Menggunakan Kode untuk Identifikasi Lokasi Dokumen
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </small>
                                    <div class="col-md-4">
                                        <div class="switch">
                                            <label>Tidak
                                                <input id="is_use_code" name="is_use_code" type="checkbox" <?= (($data['is_use_code'] or !isset($id)) ? 'checked' : '') ?>><span class="lever switch-col-pink"></span>Ya
                                            </label><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right p-l-0 p-r-0">
                                    <a class="post-right hidden-xs-down">
                                        <button type="submit" class="btn btn-success btn-md post-footer-btn"><?= (isset($id)) ? 'Simpan' : 'Tambah' ?></button>
                                    </a>
                                    <a class="hidden-sm-up">
                                        <button type="submit" class="btn btn-success btn-sm post-footer-btn"><?= (isset($id)) ? 'Simpan' : 'Tambah' ?></button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".select2").select2();
    function goBack() {
        location.href = "<?php echo site_url($path . $class) ?>";
    }

    function goSave() {
        $("#form_data").submit();
    }

</script>