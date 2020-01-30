<!-- Table Responsive -->
<!-- jQuery peity -->
<script src="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw.jquery.js') ?>"></script>
<script src="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw-init.js') ?>"></script>

<!-- Bootstrap responsive table CSS -->
<link href="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw.css') ?>" rel="stylesheet">
<!-- End Responsive Table -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex no-block col-md-7">
                        <h3 class="card-title">
                            Informasi Akses Aplikasi
                                <?php 
                                    if (isset($filter['date'])) { 
                                        echo " ( ";
                                        if ($filter['date']['start']==date("d M Y") and $filter['date']['end']==date("d M Y")){
                                            echo "Hari ini";
                                        } else {
                                            echo $filter['date']['start']." <small>sampai</small> ".$filter['date']['end'];
                                        }
                                        echo " )";
                                    }
                                ?>                                
                        </h3>
                    </div>
                    <!-- Tempat Button -->
                    <div class="col-md-5">
                        <?php
                            if (!empty($buttons)) {
                                foreach ($buttons as $btn) {
                                    ?>
                                    <button type="<?php echo empty($btn['submit']) ? 'button' : 'submit' ?>" class="btn btn-<?php echo $btn['type'] ?> pull-xs-down-left pull-xs-up-right" style="margin-right: 5px"
                                        <?php echo (empty($btn['click']) ? '' : ' onClick="' . $btn['click'] . '"') ?> <?php echo $btn['add'] ?>>
                                        <i class="mdi mdi-<?php echo $btn['icon'] ?>"></i> <?php echo $btn['label'] ?>
                                    </button>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <!-- End Tempat Button -->
                </div>
                <div class="row">
                    <div class="d-flex no-block col-md-7">
                        <h6 class="card-subtitle m-b-0 hidden-xs-down <?= !isset($filter['filtered_by']) ? 'hidden' : ''; ?>">
                            Filter berdasarkan : 
                            <b class="text-info">
                                <?= $filter['filtered_by'] ?>
                            </b>
                        </h6> 
                        <h6 class="card-subtitle m-t-10 hidden-sm-up <?= !isset($filter['filtered_by']) ? 'hidden' : ''; ?>">
                            Filter berdasarkan : 
                            <b class="text-info">
                                <?= $filter['filtered_by'] ?>
                            </b>
                        </h6>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="tablesaw table-bordered table-hover table table-condensed table-striped custom-color-bordered-table custom-bordered-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" data-tablesaw-sortable-default-col>Nama</th>
                                <!-- <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">No</th> -->
                                <!-- <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4" style="width:10%">Username</th> -->
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Tanggal</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3" >Tipe</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4" >Status</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                                foreach ($data as $v) {
                                    $no++;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $v['name'] ?></td>
                                        <td class="text-center"><?= $v['datetime'] ?></td>
                                        <!-- <td class="text-right"><?php//= $no ?></td> -->
                                        <!-- <td class="text-center"><?php//= $v['username'] ?></td> -->
                                        <td class="text-center"><?php
                                            switch ($v['type']) {
                                                case User_log_model::TYPE_ACCESS:
                                                    echo '<span class="label label-warning">Access</span>';
                                                    break;
                                                case User_log_model::TYPE_PROFILE:
                                                    echo '<span class="label label-primary">Profile Change</span>';
                                                    break;
                                                case User_log_model::TYPE_PASSWORD:
                                                    echo '<span class="label label-danger">Password Change</span>';
                                                    break;
                                                case User_log_model::TYPE_SETTING:
                                                    echo '<span class="label label-inverse">Setting</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?= $v['status_name'] ?></td>
                                        <td class="text-center"><?= $v['description'] ?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            <?php if ($no==0) { ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('_modals.php'); ?>
<style type="text/css">
    .tablesaw-modeswitch{
        /*display: none !important;*/
    }
</style>
<script>
    function submitFilter(){
        $("#filter_form").submit();
    }
    function goFilter(){
        $("#modal_filter").modal("show");

        // setting action and method
        document.getElementById('form_filter').action = "<?= site_url('web/user_log')?>";
        document.getElementById('form_filter').method = "POST";

        // setting isi form
        document.getElementById("modal_filter_body").innerHTML = 
                        `<div class="col-sm-12">
                            <div class="row bord-bottom">
                                <label class="col-sm-2 hidden-xs-down">Tanggal </label>
                                <div class="col-sm-4">
                                    <?php echo form_input(array('name' => 'date_start', 'value' => $filter['date']['start'], 'class' => 'form-control input-sm', 'id' => 'date_start', 'placeholder'=>'Tanggal Awal', 'tipe'=>'date', 'autocomplete'=>'off')) ?>
                                </div>
                                <div class="col-sm-2">
                                    <center><small style="vertical-align:bottom">
                                        sampai
                                    </small></center>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo form_input(array('name' => 'date_end', 'value' => $filter['date']['end'], 'class' => 'form-control input-sm', 'id' => 'date_end','placeholder'=>'Tanggal Akhir', 'tipe'=>'date', 'autocomplete'=>'off')) ?>
                                </div>
                            </div>                            
                            <hr>
                            <div class="row bord-bottom">
                                <label class="col-sm-2 hidden-xs-down">Keyword </label>
                                <div class="col-sm-10">
                                    <?php echo form_input(array('name' => 'keyword', 'value' => $filter['keyword'], 'class' => 'form-control input-sm', 'id' => 'keyword', 'placeholder'=>'Nama Pengguna, Keterangan...', 'autocomplete'=>'off')) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row bord-bottom m-t-10">
                                <label class="col-sm-2">Tipe </label>
                                <div class="col-sm-10">
                                    <div class="input-group m-b-5">
                                        <?php foreach ($variables['types'] as $key => $type) { ?>
                                            <input type="checkbox" class="chk-col-<?= $type['color'] ?>" id="type-<?= $key ?>" name="type-<?= $key ?>" <?= $type['checked'] ?>>
                                            <label class="m-r-10" for="type-<?= $key ?>"><?= $type['name'] ?></label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row bord-bottom m-t-10">
                                <label class="col-sm-2">Status </label>
                                <div class="col-sm-10">
                                    <div class="input-group m-b-5">
                                        <?php foreach ($variables['status'] as $key => $status) { ?>
                                            <input type="checkbox" class="chk-col-<?= $status['color'] ?>" id="status-<?= $key ?>" name="status-<?= $key ?>" <?= $status['checked'] ?>>
                                            <label class="m-r-10" for="status-<?= $key ?>"><?= $status['name'] ?></label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        // Use datepicker on the date inputs
        var today = new Date();
        $("input[tipe='date']").datepicker({
            format: 'dd M yyyy',
            autoclose:true,
            endDate: "today",
            maxDate: today,
            onSelect: function(dateText, inst) {
                $(inst).val(dateText); // Write the value in the input
            }
        });

        // on end change
        $("#date_end").on('changeDate', function (selected) {
            var date_end = new Date(selected.date.valueOf());
            var date_start = new Date($("#date_start").val());
            if (date_start > date_end)
                $("#date_start").datepicker('setDate',date_end);
        });

        // on start change
        $("#date_start").on('changeDate', function (selected) {
            var date_start = new Date(selected.date.valueOf());
            var date_end = new Date($("#date_end").val());
            if (date_start > date_end)
                $("#date_end").datepicker('setDate',date_start);
        });

        $(".select2").select2({
        });

        $("#type").select2({
            'placeholder' : "Pilih Tipe . . ."
        });

        $("#status").select2({
            'placeholder' : "Pilih Status . . ."
        });
    }

    function goClear(){
        location.href = "<?= site_url('web/user_log') ?>";
    }
</script>