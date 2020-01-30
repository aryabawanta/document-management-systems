<div class="row">
    <div class="col-12">
        <div class="alert alert-warning hidden-sm-up" style="text-align: justify;">
            Dengan mempertimbangkan sekuritas sistem, <b class="text-danger">Versi FULL</b> (edit + delete) dari fitur ini hanya bisa digunakan di <b class="text-danger"> Laptop / Komputer</b>. Versi mobile hanya mengakomodasi penambahan Unit Kerja.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex no-block col-md-7">
                        <h3 class="card-title"><?php echo $title; ?></h3>
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
                <div id="treeview" class=""></div>
                <!-- Context-menu -->
                <input type='hidden' value='' id='txt_id'>
                <?php// include('_context_menu_treeview.php'); ?>
                <!-- End Context Menu -->
            </div>
        </div>
    </div>
</div>

<!-- Treeview Plugin JavaScript -->
<style type="text/css">
    .badge{
        float:right;
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        /*color: #fff;*/
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        /*background-color: #f62d51;*/
        /*background-color: black;*/
        border-radius: 10px;
    }
    .indent{
        margin-right: 15px !important;
        margin-left: 15px !important;
    }
</style>
<script src="<?= base_url('assets/web/plugins/bootstrap-treeview-master/src/js/bootstrap-treeview.js') ?>"></script>
<script type="text/javascript">
    $(function() {
        var data = <?= $workunits ?>;
        // var defaultData = [
        //   {
        //     "text": ' Parent 1',
        //     "href": '#parent1',
        //     "tags": ['4'],
        //     "nodes": [
        //       {
        //         text: 'Child 1',
        //         href: '#child1',
        //         tags: ['2'],
        //         nodes: [
        //           {
        //             text: 'Grandchild 1',
        //             href: '#grandchild1',
        //             tags: ['0']
        //           },
        //           {
        //             text: 'Grandchild 2',
        //             href: '#grandchild2',
        //             tags: ['0']
        //           }
        //         ]
        //       },
        //       {
        //         text: 'Child 2',
        //         href: '#child2',
        //         tags: ['0']
        //       }
        //     ]
        //   },
        //   {
        //     text: 'Parent 2',
        //     href: '#parent2',
        //     tags: ['0']
        //   },
        //   {
        //     text: 'Parent 3',
        //     href: '#parent3',
        //      tags: ['0']
        //   },
        //   {
        //     text: 'Parent 4',
        //     href: '#parent4',
        //     tags: ['0']
        //   },
        //   {
        //     text: 'Parent 5',
        //     href: '#parent5'  ,
        //     tags: ['0']
        //   }
        // ];

        $('#treeview').treeview({
            expandIcon: 'ti-angle-right',
            onhoverColor: "rgba(0, 0, 0, 0.05)",
            selectedBackColor: "#03a9f3",
            collapseIcon: 'ti-angle-down',
            // nodeIcon: 'mdi mdi-account-multiple',
            nodeIcon: 'mdi mdi-subdirectory-arrow-right',
            topNodeIcon:'mdi mdi-home-modern',
            showTags: true,
            data: data
        });
    });
</script>
<!-- End Treeview Plugin JavaScript -->

<script>
    // $(document).ready(function() {
    //     $(".select2").select2({
    //     });

    //     $("#workunit").select2({
    //         'placeholder' : "Pilih Unit Kerja . . ."
    //     });
    // });

    function goAdd(){
        location.href = "<?= site_url('web/workunit/add') ?>";
    }

    function submitFilter(){
        $("#filter_form").submit();
    }
</script>