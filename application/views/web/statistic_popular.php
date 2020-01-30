<!-- Page CSS -->
<!-- End Page CSS -->

<!-- Content -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"> Popular Classifications</h3>
                    <hr>
                    <div>
                        <canvas id="chart-classification" height="150"> </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"> Popular Search</h3>
                    <hr>
                    <div>
                        <canvas id="chart-search" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
<!-- End Content -->

<!-- Page Javascript -->
    <script type="text/javascript">
            $( document ).ready(function() {
                new Chart(document.getElementById("chart-classification"),{
                    "type":"horizontalBar",
                    "data":{"labels":<?= $data['classification']['label'] ?>,
                    "datasets":[{
                                    "label":"Popular Classifications Bar",
                                    "data":<?= $data['classification']['data'] ?>,
                                    "fill":false,
                                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)"],
                                    "borderColor":["rgb(252, 75, 108)","rgb(255, 159, 64)","rgb(255, 178, 43)","rgb(38, 198, 218)","rgb(54, 162, 235)"],
                                    "borderWidth":1}
                                ]},
                    "options":{
                        "scales":{"xAxes":[{"ticks":{"beginAtZero":true}}]}
                    }
                });

                new Chart(document.getElementById("chart-search"),{
                    "type":"horizontalBar",
                    "data":{"labels":<?= $data['search']['label'] ?>,
                    "datasets":[{
                                    "label":"Popular Search",
                                    "data":<?= $data['search']['data'] ?>,
                                    "fill":false,
                                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)"],
                                    "borderColor":["rgb(252, 75, 108)","rgb(255, 159, 64)","rgb(255, 178, 43)","rgb(38, 198, 218)","rgb(54, 162, 235)"],
                                    "borderWidth":1}
                                ]},
                    "options":{
                        "scales":{"xAxes":[{"ticks":{"beginAtZero":true}}]}
                    }
                });
            });
        </script>
        <script src="<?= base_url('assets/web/plugins/Chart.js/Chart.min.js') ?>"></script>
<!-- End Page Javascript -->