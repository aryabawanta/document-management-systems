<!-- CSS -->
    <style>
        .pagination {
            display: inline-block;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #26c6da;
            color: white;
            border: 1px solid #26c6da;
        }

        .pagination a:hover:not(.active) {background-color: #ddd;}

        .pagination a:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .pagination a:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        @media(max-width: 576px){
            .pagination a{
                padding: 4px 8px;
            }
        }
    </style>
<!-- End CSS -->

<!-- Content -->
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="card m-b-0 p-b-0  p-t-20" style="box-shadow: none;border:none;">
                <div class="card-body m-b-0 p-b-0" >
                    <div class="row">
                        <div class="d-flex no-block col-md-7 m-b-10">
                            <h4 class="card-title"><?= $title ?></h4>
                        </div>
                        <div class="col-md-5 text-align-sm-up-right">
                            
                            <?php
                                foreach ($buttons as $button) {
                                ?>
                                    <button class="btn btn-<?= $button['type'] ?> " style="margin-right: 20px;margin-bottom: 10px;" onClick="<?= $button['click'] ?>">
                                        <i class="mdi mdi-<?= $button['icon'] ?>"></i>
                                        <?= $button['label']?>
                                    </button>
                                <?php
                                }
                            ?>
                            <button class="btn btn-sm btn-circle btn-secondary custom-right-side-toggle hidden m-b-10  hidden-mobile" style="margin-right: 20px;" onClick="">
                                <i class="mdi mdi-information-variant"></i>
                            </button>
                        </div>
                    </div>
                    <?php if (isset($filtered_by)) { ?>
                        <div class="row m-t-10">
                            <div class="col-md-<?= $filter_col ?>">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="mdi mdi-filter"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control force-font-13" value="<?= $filtered_by ?>" disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger" type="button" onclick="goClearFilter()"><i class="mdi mdi-close"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- List Document -->
            <div class="col-lg-12 p-0" id="content">
                <div class="card" style="box-shadow: none;border:none;border-top:0.5px solid #f3f1f1">
                    <div class="card-body p-t-10 m-t-0" >
                        <div class="table-responsive m-t-5" >
                            <table id="table_document" class="table force-font-13 mobile-force-font-10 table-hide-overflow " data-tablesaw-sortable data-tablesaw-mode="swipe">
                                <thead style="border-bottom:0.5px solid #f3f1f1;">
                                    <tr>
                                        <th class="width-60" data-tablesaw-sortable-col data-tablesaw-priority="persist" >Nama</th>
                                        <th class="width-10" data-tablesaw-sortable-col data-tablesaw-priority="2">Arsip</th>
                                        <th class="width-10" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Tahun</th>
                                        <th class="width-20" data-tablesaw-sortable-col data-tablesaw-priority="1">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody style="border-top:0.5px solid #f3f1f1;border-bottom:0.5px solid #f3f1f1;">
                                    <?php $no=0; ?>
                                    <?php foreach ($data as $document) { $no++;?>
                                        <tr class="clickable-row" data-url="<?= $document['id'] ?>" id="tr_<?=$no?>">
                                            <td>
                                                <div class="hide-overflow">
                                                    <img class="m-r-20" src="<?= $document['image'] ?>" alt="" style="width:20px;">
                                                    <?= $document['name'] ?>
                                                </div>
                                            </td>
                                            <td>
                                               <?= $document['archive_number'] ?>
                                            </td>
                                            <td ><?= $document['year'] ?></td>
                                            <td ><?= $document['location_code'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($no==0){ ?>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Tidak ada Dokumen
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="m-t-10">
                                    <tr>
                                        <td class="font-bold force-font-13 mobile-force-font-10">
                                            <span class="text-success"><?= $counter['page_document'] ?></span><i> dari</i> <span class="text-success"><?= $counter['documents'] ?></span><i> dokumen</i>
                                        </td>
                                        <td colspan="3" class="font-bold force-font-13 mobile-force-font-10">
                                            Total : 
                                            <span class="text-info m-l-10"><?= $counter['blocks'] ?></span><i> Blok</i>,
                                            <span class="text-info m-l-10"><?= $counter['racks'] ?></span><i> Rak</i>, 
                                            <span class="text-info m-l-10"><?= $counter['boxes'] ?></span><i> Box</i>, 
                                            <span class="text-info m-l-10"><?= $counter['envelopes'] ?></span><i> Sampul</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="pagination force-font-11 text-success mobile-force-font-10">
                                                <?php 
                                                    $page_number = 1; 
                                                    if ($page>2)
                                                        $page_number = $page-2;
                                                    elseif ($page>1)
                                                        $page_number = $page-1;
                                                    if (($max_page-3)<$page)
                                                        $page_number = $max_page-4;
                                                    if ($page_number<=0)
                                                        $page_number = 1;
                                                ?>
                                                <?php $page_count = 0; ?>
                                                <?php for ($i=$page_number; $i <= $max_page; $i++) { ?>
                                                    <?php if ($page_count==5) break; ?>
                                                    <a <?= $page==$i ? 'class="active"' : '' ?> href="<?= site_url($path.$class.'/index/'.$i) ?>"><?= $i ?></a>
                                                    <?php $page_count++; ?>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End List Document -->
        <!-- Right Card -->
            <div class="col-lg-4 p-0 hidden hidden-mobile" id="content_right">
                <div class="card" style="box-shadow: none;border:none;border-top:0.5px solid #f3f1f1;border-left:1px solid #f3f1f1">
                    <div class="card-body p-t-10 m-t-0">
                        <div class="card-title p-b-20 p-t-10">
                            <div class="row">
                                <div class="col-2 text-center">
                                    <img id="doc_info_file_format" src="<?= base_assets().'/images/document/file.png' ?>" alt="" style="width:40px;">
                                </div>
                                <div class="col-10">
                                    <h5 id="doc_info_name">
                                        [Nama Dokumen]
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <!-- <h6 class="card-subtitle">Use default tab with class <code>nav-tabs &amp; tabcontent-border </code></h6> -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> 
                                <a class="nav-link active show" data-toggle="tab" href="#content_right_detail" role="tab" aria-selected="true">
                                    <span><i class="mdi mdi-file-document-box"></i> Detail</span>
                                </a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" data-toggle="tab" href="#content_right_activity" role="tab" aria-selected="false">
                                    <span><i class="mdi mdi-run"></i> Activity</span>
                                </a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" data-toggle="tab" href="#content_right_history" role="tab" aria-selected="false">
                                    <span><i class="mdi mdi-history"></i></span> History
                                </a> 
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active show" id="content_right_detail" role="tabpanel">
                                <div class="card" style="border:none;box-shadow: none;">
                                    <?php if (1==0) { ?>
                                        <!-- KALO MAU ADA FOTONYA -->
                                        <!-- <div class="card-body">
                                            <center class="m-t-30"> <img src="../assets/images/users/5.jpg" class="img-circle" width="150">
                                                <h4 class="card-title m-t-10">Hanna Gover</h4>
                                                <h6 class="card-subtitle">Accoubts Manager Amix corp</h6>
                                                <div class="row text-center justify-content-md-center">
                                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                                </div>
                                            </center>
                                        </div>
                                        <div><hr></div> -->
                                    <?php } ?>
                                    <div class="card-body" > 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Nama Folder </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_folder_name">[Nama Folder]</h6></div>
                                        </div> 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Nama File </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_file_name">[Nama File]</h6></div>
                                        </div> 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Klasifikasi </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_classification_code">[Klasifikasi]</h6></div>
                                        </div> 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Pemilik </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_workunit_name">[Pemilik]</h6></div>
                                        </div> 
                                        <hr />
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Tahun </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_year">[Tahun]</h6></div>
                                        </div> 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">No Arsip </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_archive_number">[No Arsip]</h6></div>
                                        </div> 
                                        <div class="row p-t-5">
                                            <div class="col-4"><small class="text-muted ">Lokasi </small></div>
                                            <div class="col-8"><h6 style="margin-top: 5px" id="doc_info_location_code">[Lokasi]</h6></div>
                                        </div>            

                                        <div class="row p-t-5">
                                            <div class="col-3">
                                                <small class="text-muted p-t-5 db">Blok</small>
                                                <h6 id="doc_info_block_code">[Blok]</h6>  
                                            </div>
                                            <div class="col-3">
                                                <small class="text-muted p-t-5 db">Rak</small>
                                                <h6 id="doc_info_rack_code">[Rak]</h6>  
                                            </div>
                                            <div class="col-3">
                                                <small class="text-muted p-t-5 db">Box</small>
                                                <h6 id="doc_info_box_code">[Box]</h6>  
                                            </div>
                                            <div class="col-3">
                                                <small class="text-muted p-t-5 db">Sampul</small>
                                                <h6 id="doc_info_envelope_code">[Sampul]</h6> 
                                            </div>
                                        </div>

                                        <div class="row p-t-5 db">
                                            <div class="col-4"><small class="text-muted ">Kondisi </small></div>
                                            <div class="col-8"><h6 id="doc_info_condition">[Kondisi]</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="content_right_activity" role="tabpanel">
                                <div class="card-body p-0 p-t-10 force-font-11">
                                    <div class="profiletimeline p-t-20" id="doc_info_div_activity">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="content_right_history" role="tabpanel">
                                <div class="card-body p-0 p-t-10 force-font-11">
                                    <div class="profiletimeline p-t-20" id="doc_info_div_history">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Right Card -->
    </div>
<!-- End Content -->

<!-- Includes -->
    <!-- CSS -->
    <?php include("css/_document_index_css.php"); ?>

    <!-- Context Menu, Include Edit document, but the get data is in document_index_js.php -->
    <?php include('_document_context_menu.php'); ?>

    <!-- modals, for filter -->
    <?php include('_modals.php'); ?>
    <?php include("js/_document_filter_js.php"); ?>

    <!-- This page javascript -->
    <?php include("js/_document_index_js.php"); ?>
<!-- End Includes -->

<!-- Script -->
<!-- End Script -->
