<?php if (SessionManagerWeb::isAuthenticated()) { ?>
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header hidden-sm-down">
                <a class="navbar-brand" href="<?= site_url() ?>">
                    <!-- Logo icon -->
                    <b>
                        <img src="<?= site_url('assets/web/images/favicon-white.png')?>" alt="homepage" class="light-logo" style="height:40px"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <?php if (1==0) { ?>
                        <span> 
                            <img src="<?= site_url('assets/web/images/favicon.png') ?>" class="light-logo" alt="homepage" style="height:40px" />
                        </span> 
                    <?php } ?>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto mt-md-0 m-l-20">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    
                </ul>
                <ul class="navbar-nav mr-auto hidden">
                    <li class="nav-item">
                        <a href="<?= site_url('web/user_application') ?>">
                            <!-- Logo icon -->
                            <b>
                                <img src="<?= site_url('assets/web/images/favicon-white.png')?>" alt="homepage" class="light-logo" style="height:40px"/>
                            </b>
                        </a>
                    </li>
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    <li class="nav-item search-box" style="padding-top: 5px">
                        <a class="nav-link text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                        <form class="app-search" method="POST">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Document name . . ." value="<?= $filter['name'] ?>"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                    </li>
                    <!-- ============================================================== -->
                    <!-- Profile -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= SessionManagerWeb::getPhoto()?>" alt="user" class="profile-pic" /></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box row">
                                        <div class="u-img col-4"><img src="<?= SessionManagerWeb::getPhoto()?>" alt="user"></div>
                                        <div class="u-text col-8">
                                            <h5><?= SessionManagerWeb::getName() ?></h5>
                                            <p class="text-muted"><?= Role::name(SessionManagerWeb::getRole()) ?></p>
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?= site_url('web/user/changeApplication')?>"><i class="mdi mdi-apps"></i> Pindah Aplikasi</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?= site_url('web/user/logout') ?>"><i class="mdi mdi-power"></i> Keluar</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<?php } ?>


