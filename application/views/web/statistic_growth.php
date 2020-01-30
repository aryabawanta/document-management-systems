<!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= $title ?></h3>
                    <hr>
                    <div>
                        <canvas id="chart-document" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"> Digitalized</h3>
                    <hr>
                    <div>
                        <canvas id="chart-digitalized" height="150"> </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Content -->

<!-- Javascript -->
    <!-- Chart JS -->
        <script type="text/javascript">
            $( document ).ready(function() {

                new Chart(document.getElementById("chart-document"),{
                    "type":"line",
                    "data":{"labels":<?= $data['document']['label'] ?>,
                    "datasets":[{
                                    "label":"Document Growth",
                                    "data":<?= $data['document']['data'] ?>,
                                    "fill":false,
                                    "borderColor":"rgb(38, 198, 218)",
                                    "lineTension":0.1
                                }]
                },"options":{}});

                new Chart(document.getElementById("chart-digitalized"),{
                    "type":"doughnut",
                    "data":{"labels":["Hardcopy","Digitalized"],
                    "datasets":[{
                        "label":"Digitalized",
                        "data":[<?= $data['digitalized']['hardcopy'].','.$data['digitalized']['digitalized'] ?>],
                        "backgroundColor":["#e0e0e0","#4fc3f7"]}
                    ]}
                });
            });
        </script>
        <script src="<?= base_url('assets/web/plugins/Chart.js/Chart.min.js') ?>"></script>
    <!-- End Chart JS -->
<!-- End Javascript -->