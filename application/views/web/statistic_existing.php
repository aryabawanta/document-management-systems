<!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title m-b-0"><?php echo $title; ?></h3>
                </div>
            </div>
        </div>
    </div>
<!-- End Title -->

<!-- Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <!-- Total Blocks -->
                    <div class="col-md-4">
                        <div class="card card-inverse card-danger">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-border-all"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total Blocks</h3>
                                        <h6 class="card-subtitle">Per <?= date('d M Y') ?></h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 align-self-center text-center">
                                        <h1 class="text-white"><?= $data['total']['blocks'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End Total Blocks -->

                <!-- Total Racks -->
                    <div class="col-md-4">
                        <div class="card card-inverse card-warning">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-square-inc"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total Racks</h3>
                                        <h6 class="card-subtitle">Per <?= date('d M Y') ?></h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 align-self-center text-center">
                                        <h1 class="text-white"><?= $data['total']['racks'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End Total Racks -->

                <!-- Total Boxes -->
                    <div class="col-md-4">
                        <div class="card card-inverse card-primary">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-archive"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total Boxes</h3>
                                        <h6 class="card-subtitle">Per <?= date('d M Y') ?></h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 align-self-center text-center">
                                        <h1 class="text-white"><?= $data['total']['boxes'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End Total Boxes -->

                <!-- Total Envelopes -->
                    <div class="col-md-4">
                        <div class="card card-inverse card-info">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-folder-multiple"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total Envelopes</h3>
                                        <h6 class="card-subtitle">Per <?= date('d M Y') ?></h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 align-self-center text-center">
                                        <h1 class="text-white"><?= $data['total']['envelopes'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End Total Envelopes -->

                <!-- Total Documents -->
                    <div class="col-md-4">
                        <div class="card card-inverse card-success">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-file-chart"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total Documents</h3>
                                        <h6 class="card-subtitle">Per <?= date('d M Y') ?></h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 align-self-center text-center">
                                        <h1 class="text-white"><?= $data['total']['documents'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End Total Documents -->
            </div>
            
            
        </div>
    </div>
<!-- End Content -->