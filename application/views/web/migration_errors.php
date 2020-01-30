<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex no-block col-md-7">
                        <h3 class="card-title">
                            Migration Errors <small>( total : <?= $error_total; ?> )</small>                    
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
                <hr>
                <div class="table-responsive">
                    <table class="tablesaw table-bordered table-hover table table-condensed color-bordered-table success-bordered-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" data-tablesaw-sortable-default-col>Row</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" style="width:50%">Nama</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" style="width:50%">Error</th>
                                <!-- <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Lokasi</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Nama Folder / Sampul</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Nama File</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Klasifikasi</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Unit Kerja</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Tahun</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="8">No Arsip</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="9">Sampul</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Box</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="13">Rak</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="11">Blok</th>
                                <th class="text-center" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="12">Kondisi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($error_datas as $error) { $no++; ?>
                                    <tr>
                                        <td class="text-center"><?= $error['row'] ?></td>
                                        <td class="text-center"><?= $error['name'] ?></td>
                                        <td class="text-center"><?= $error['error'] ?></td>
                                        <!-- <td class="text-center"><?= $error['location_code'] ?></td>
                                        <td class="text-center"><?= $error['folder_name'] ?></td>
                                        <td class="text-center"><?= $error['file_name'] ?></td>
                                        <td class="text-center"><?= $error['classification_code'] ?></td>
                                        <td class="text-center"><?= $error['workunit_id'] ?></td>
                                        <td class="text-center"><?= $error['year'] ?></td>
                                        <td class="text-center"><?= $error['archive_number'] ?></td>
                                        <td class="text-center"><?= $error['envelope_code'] ?></td>
                                        <td class="text-center"><?= $error['box_code'] ?></td>
                                        <td class="text-center"><?= $error['rack_code'] ?></td>
                                        <td class="text-center"><?= $error['block_code'] ?></td>
                                        <td class="text-center"><?= $error['condition'] ?></td> -->
                                    </tr>
                            <?php } ?>
                            <?php if ($no==0) { ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada error.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function goDownload(){
        location.href = "<?= site_url('web/export/migrationErrors') ?>";
    }
</script>