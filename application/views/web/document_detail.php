<!-- CSS -->
    <style type="text/css">
        .force-font-13{
            font-size: 13px!important;
        }
        .force-font-11{
            font-size: 11px!important;
        }
        @media (max-width: 575px) {
            .hide-overflow {
               overflow: hidden;
               text-overflow: ellipsis;
               display: -webkit-box;
               line-height: 16px;     /* fallback */
               max-height: 50px;      /* fallback */
               -webkit-line-clamp: 3; /* number of lines to show */
               -webkit-box-orient: vertical;
            }
            .mobile-force-font-11{
                font-size: 11px!important;
            }
            .mobile-force-font-10{
                font-size: 10px!important;
            }
        }
    </style>
<!-- End CSS -->

<!-- Content -->
    <div class="row">
        <div class="col-lg-6 p-0">
            <div class="card" style="box-shadow: none;border:none;border-top:0.5px solid #f3f1f1;border-left:1px solid #f3f1f1">
                <div class="card-body p-t-10 m-t-0">
                    <div class="card-title p-b-20 p-t-10">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-secondary" style="margin-right: 5px"
                                    onClick="javascript:goBack()">
                                    <span class="mobile-force-font-11"><i class="fa fa-chevron-left"></i> Back</span>
                                </button>
                            </div>
                        </div>
                        <hr / >
                        <div class="row">
                            <div class="col-2 col-md-1 text-center">
                                <img id="doc_info_file_format" src="<?= base_assets().'/images/document/file.png' ?>" alt="" style="width:40px;">
                            </div>
                            <div class="col-10 col-md-11">
                                <h6 class="mobile-force-font-11" id="doc_info_name">
                                    <?= $data['name'] ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mobile-force-font-10" role="tablist">
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
                                <div class="card-body mobile-force-font-11"> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Nama Folder </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_folder_name"><?= $data['folder_name'] ?></h6></div>
                                    </div> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Nama File </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_file_name"><?= $data['file_name'] ?></h6></div>
                                    </div> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Klasifikasi </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_classification_code"><?= $data['classification_code'] ?></h6></div>
                                    </div> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Pemilik </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_workunit_name"><?= $data['workunit_name'] ?></h6></div>
                                    </div> 
                                    <hr />
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Tahun </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_year"><?= $data['year'] ?></h6></div>
                                    </div> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">No Arsip </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_archive_number"><?= $data['archive_number'] ?></h6></div>
                                    </div> 
                                    <div class="row p-t-5">
                                        <div class="col-4"><small class="text-muted ">Lokasi </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" style="margin-top: 5px" id="doc_info_location_code"><?= $data['location_code'] ?></h6></div>
                                    </div>            

                                    <div class="row p-t-5">
                                        <div class="col-3">
                                            <small class="text-muted p-t-5 db">Blok</small>
                                            <h6 class="mobile-force-font-11" id="doc_info_block_code"><?= $data['block_code'] ?></h6>  
                                        </div>
                                        <div class="col-3">
                                            <small class="text-muted p-t-5 db">Rak</small>
                                            <h6 class="mobile-force-font-11" id="doc_info_rack_code"><?= $data['rack_code'] ?></h6>  
                                        </div>
                                        <div class="col-3">
                                            <small class="text-muted p-t-5 db">Box</small>
                                            <h6 class="mobile-force-font-11" id="doc_info_box_code"><?= $data['box_code'] ?></h6>  
                                        </div>
                                        <div class="col-3">
                                            <small class="text-muted p-t-5 db">Sampul</small>
                                            <h6 class="mobile-force-font-11" id="doc_info_envelope_code"><?= $data['envelope_code'] ?></h6> 
                                        </div>
                                    </div>

                                    <div class="row p-t-5 db">
                                        <div class="col-4"><small class="text-muted ">Kondisi </small></div>
                                        <div class="col-8"><h6 class="mobile-force-font-11" id="doc_info_condition"><?= $data['condition'] ?></h6></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="content_right_activity" role="tabpanel">
                            <div class="card-body p-0 p-t-10 force-font-11">
                                <div class="profiletimeline p-t-20" id="doc_info_div_activity">
                                    <?php if (empty($data['activity'])) { ?>
                                        <div class="sl-item m-b-0">
                                            <div class="text-center">
                                                <strong class="font-bold force-font-11">No Activity Found</strong>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php } else { ?>
                                        <?php foreach ($data['activity'] as $activity) { ?>
                                            <div class="sl-item m-b-0">
                                                <div class="sl-left"> <img src="<?= base_url('assets/uploads/users/photos/nopic.png') ?>" alt="User" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <strong class="font-bold force-font-11"><?= $activity['user_name'] ?></strong>
                                                        <br> 
                                                        <span class="sl-date force-font-11"><?= $activity['datetime'] ?></span>
                                                        <p class="force-font-11 m-b-0"><?= $activity['text'] ?></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="content_right_history" role="tabpanel">
                            <div class="card-body p-0 p-t-10 force-font-11">
                                <div class="profiletimeline p-t-20" id="doc_info_div_history">
                                    <?php if (empty($data['history'])) { ?>
                                        <div class="sl-item m-b-0">
                                            <div class="text-center">
                                                <strong class="font-bold force-font-11">No History Found</strong>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php } else { ?>
                                        <?php foreach ($data['history'] as $history) { ?>
                                            <div class="sl-item m-b-0">
                                                <div class="sl-left"> <img src="<?= base_url('assets/uploads/users/photos/nopic.png') ?>" alt="User" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <strong class="font-bold force-font-11"><?= $history['user_name'] ?></strong>
                                                        <br> 
                                                        <span class="sl-date force-font-11"><?= $history['datetime'] ?></span>
                                                        <p class="force-font-11 m-b-0"><?= $history['text'] ?></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Content -->

<!-- Script -->
    <script type="text/javascript">
        function goBack(){
            location.href = "<?= site_url($path.$class) ?>";
        }
    </script>
<!-- End Script -->
