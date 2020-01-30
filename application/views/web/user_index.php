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
                <form id="filter_form" action="<?= site_url('web/user/index') ?>" style="width:100%">
                    <div class="row" style="margin:10px 10px 10px 0px">
                        <div class="col-md-7 col-sm-4 col-xs-12 m-b-5" style="padding-left: 0px">
                            <?= form_dropdown('role', $variables['roles'], $_GET['role'], 'id="role" onChange="submitFilter()" class="form-control select2" style="width:100%"') ?>
                        </div>
                        <div class="col-md-5 col-sm-5 m-b-5 p-l-0">
                            <div class="switch pull-sm-up-right">
                                <label>
                                    <span class="hidden-xs-down">Tampilkan User Tidak Aktif</span>
                                    <span class="hidden-sm-up" style="font-size:10px">Tampilkan User Tidak Aktif</span>
                                <input type="checkbox" id="is_active" name="is_active" onChange="submitFilter()" <?= ($_GET['is_active']=='on') ? "checked" : '' ?>><span class="lever switch-col-red"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="search" class="sr-only">Search</label>
                        <input type="text" class="form-control" name="search" id="search" placeholder="Cari" value="<?= $_GET['search'] ?>" style="border:1px solid;width:96%">
                        <button type="submit" class="btn btn-secondary hidden-xs-down">
                            <span class="fas fa-search form-control-feedback" style="padding-top: 5px"></span>
                        </button>
                    </div>       
                </form>
                <?php if (isset($_GET['search'])) { ?>
                    <a href="<?= site_url('web/user/index') ?>" >
                        <button class="btn btn-warning" style="margin-bottom: 10px">
                            Bersihkan Filter
                        </button>
                    </a>
                <?php } ?>
                <div class="table-responsive color-bordered-table success-bordered-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($data as $v) {
                                $no++;
                                ?>
                                <tr>
                                    <td class="text-right"><?= $no ?></td>
                                    <td><?= $v['name'] ?></td>
                                    <td><?= $v['username'] ?></td>
                                    <td class="text-center"><?php
                                        switch ($v['role']['id']) {
                                            case Role::ADMINISTRATOR:
                                                echo '<span class="label label-success">' . Role::name($v['role']['name']) . '</span>';
                                                break;
                                            case Role::USER:
                                                echo '<span class="label label-warning">' . Role::name($v['role']['name']) . '</span>';
                                                break;
                                        }
                                        ?></td>
                                    <td class="text-center"><?php
                                        switch ($v['status']) {
                                            case Status::ACTIVE:
                                                echo '<span class="label label-success">Aktif</span>';
                                                break;
                                            case Status::DRAFT:
                                                echo '<span class="label label-warning">Draft</span>';
                                                break;
                                            case Status::INACTIVE:
                                                echo '<span class="label label-danger">Tidak Aktif</span>';
                                                break;
                                            case Status::VOID:
                                                echo '<span class="label label-danger">Dihapus</span>';
                                                break;
                                        }
                                        ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php if ($no==0){ ?>
                                <td class="text-center" colspan="5">
                                    Tidak Ada Data.
                                </td>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(".select2").select2({
        });

        $("#role").select2({
            'placeholder' : "Pilih Role . . ."
        });

        $("#workunit").select2({
            'placeholder' : "Pilih Unit Kerja . . ."
        });
    });

    function submitFilter(){
        $("#filter_form").submit();
    }

    function goAdd(){
        location.href = "<?= site_url('web/user/add') ?>";
    }

    function goSync(){
        location.href = "<?= site_url('web/user/syncUsers') ?>";
    }
</script>