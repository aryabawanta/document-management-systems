<!-- Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= $title ?></h3>
                    <div>
                        <canvas id="chart" height="150"> </canvas>
                        <center>Blocks</center>
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
                new Chart(document.getElementById("chart"),{
                    "type":"line",
                    "data":{
                        "labels":<?= $data['label'] ?>,
                        "datasets":[
                            {
                                "label":"Reality",
                                "data":<?= $data['reality'] ?>,
                                "backgroundColor":" rgba(244,67,54, 0.5)",
                                "fill":"start"
                            },
                            {
                                "label":"Filled in DB",
                                "data":<?= $data['filled'] ?>,
                                "backgroundColor":" rgba(255,193,7, 0.5)",
                                "fill":"start"
                            },
                            {
                                "label":"Capacity",
                                "data":<?= $data['capacity'] ?>,
                                "backgroundColor":"rgba(33,150,243,0.5)",
                                "fill":"start"
                            }                        
                        ]
                    },
                    options: {
                        spanGaps: false,
                        elements: {
                            line: {
                                tension: 0.000001
                            }
                        },
                        scales: {
                            yAxes: [{
                                stacked: false
                            }]
                        },
                        plugins: {
                            filler: {
                                propagate: false
                            }
                        }
                    }
                });
            });
        </script>
        <script src="<?= base_url('assets/web/plugins/Chart.js/Chart.min.js') ?>"></script>
    <!-- End Chart JS -->
<!-- End Javascript -->