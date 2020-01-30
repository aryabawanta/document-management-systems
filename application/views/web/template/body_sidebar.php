<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav m-t-20">
            <ul id="sidebarnav">
                <?php if (SessionManagerWeb::isAdministrator()) { ?>
                    <li class="m-b-10"> <button class="btn btn-block btn-rounded btn-info" data-toggle="modal" data-target="#upload_modal"><i class="mdi mdi-plus"></i> <span class="hide-menu">New Document</span></button>
                    </li>
                <?php } ?>
                <li class="nav-small-cap">Documents</li>
                <li> <a class="waves-effect waves-dark" href="<?= site_url('web/document') ?>" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu"> All Documents </span></a>
                </li>
                <!-- <li> <a class="waves-effect waves-dark" href="<?= site_url('web/document/me') ?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu"> My Documents </span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="<?= site_url('web/document/me') ?>" aria-expanded="false"><i class="mdi mdi-file-tree"></i><span class="hide-menu"> Work Unit Documents </span></a>
                </li> -->

                <!-- Statistics-->
                    <li class="nav-small-cap">STATISTICS</li>
                    <li> 
                        <a class="has-arrow waves-effect waves-dark" href="<?= site_url('web/classification') ?>" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu"> Statistics </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= site_url('web/statistic/existingCondition') ?>">Existing Condition </a></li>
                            <li><a href="<?= site_url('web/statistic/capacity') ?>">Capacity </a></li>
                            <li><a href="<?= site_url('web/statistic/growth') ?>">Growth </a></li>
                            <li><a href="<?= site_url('web/statistic/popular') ?>">Popular </a></li>
                        </ul>
                    </li>
                <!-- End Statistics -->
                
                <?php if (SessionManagerWeb::isAdministrator()) { ?>
                    <li class="nav-devider"></li>
                    <li class="nav-small-cap">SETTINGS</li>
                    <!-- <li> 
                        <a class="waves-effect waves-dark" href="<?= site_url('web/location') ?>" aria-expanded="false"><i class="mdi mdi-map-marker"></i><span class="hide-menu"> Locations </span></a>
                    </li> -->
                    <li> 
                        <a class="has-arrow waves-effect waves-dark" href="<?= site_url('web/classification') ?>" aria-expanded="false">
                            <i class="mdi mdi-file-tree"></i><span class="hide-menu"> Classifications </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= site_url('web/classification') ?>">Classifications List </a></li>
                            <li><a href="<?= site_url('web/migration/add/classifications') ?>">Import Classifications </a></li>
                        </ul>
                    </li>
                    <?php if (false) { ?>
                        <li> 
                            <a class="waves-effect waves-dark" href="<?= site_url('web/classification') ?>" aria-expanded="false"><i class="mdi mdi-file-tree"></i><span class="hide-menu"> Classifications </span></a>
                        </li>
                        <li> 
                            <a class="waves-effect waves-dark" href="<?= site_url('web/migration/add/classifications') ?>" aria-expanded="false"><i class="mdi mdi-file-import"></i><span class="hide-menu"> Import Classifications </span></a>
                        </li>
                    <?php } ?>

                    <li class="nav-devider"></li>
                    <li class="nav-small-cap">Migration</li>
                    <li> 
                        <a class="has-arrow waves-effect waves-dark" href="<?= site_url('web/migration/add/documents') ?>" aria-expanded="false">
                            <i class="mdi mdi-file-send"></i><span class="hide-menu"> Doc Migration </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= site_url('web/migration/add/documents') ?>">Metadata </a></li>
                            <li><a href="<?= site_url('web/migration/add/overwrite') ?>">Overwrite Migration </a></li>
                        </ul>
                    </li>

                    <?php if (false){ ?>
                        <li> 
                            <a class="waves-effect waves-dark" href="<?= site_url('web/migration/add/documents') ?>" aria-expanded="false"><i class="mdi mdi-file-send"></i><span class="hide-menu"> Data Migration </span></a>
                        </li>
                    <?php } ?>


                    <li class="nav-devider"></li>
                    <li class="nav-small-cap">SYNCHRONIZED</li>
                    <li> 
                        <a class="waves-effect waves-dark" href="<?= site_url('web/user/index') ?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu"> Users </span></a>
                    </li>
                    <li> 
                        <a class="waves-effect waves-dark" href="<?= site_url('web/workunit') ?>" aria-expanded="false"><i class="mdi mdi-sitemap"></i><span class="hide-menu"> Work Units </span></a>
                    </li>
                    
                <?php } ?>                
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll--> 
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <a href="<?= site_url('web/user/changeApplication') ?>" class="link" data-toggle="tooltip" title="Pindah Aplikasi" ><i class="mdi mdi-apps m-l-30"></i></a>
        <a href="" class="link" data-toggle="tooltip" title=""></a>
        <!-- item-->
        <a href="<?= site_url('web/user/logout') ?>" class="link" data-toggle="tooltip" title="Logout" ><i class="mdi mdi-power"></i></a> 
    </div>
    <!-- End Bottom points-->
</aside>

<script type="text/javascript">
    // $(".sidebartoggler").on('click',function(){
    //     if ($("body").hasClass("mini-sidebar")) {
    //         $(".hidden-mini-sidebar").removeClass("hidden");
    //     } else {
    //         $(".hidden-mini-sidebar").addClass("hidden");
    //     }
    // });
</script>