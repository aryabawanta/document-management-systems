<div class="container-fluid text-center">
    <a id="benchmark" href="#benchmark" onclick="toggleElement('.benchmark');">
        <h4>Benchmark <span class="glyphicon glyphicon-stats"</h4>
    </a>
</div>
<div class="container-fluid benchmark" style="margin-top: 30px;display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-condensed" style="background: white;">
                    <tr>
                        <th class="info text-right text-success">HTTP Header</span></th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::httpHeader() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . $value . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Controller Info</th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::controllerInfo() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . $value . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">POST Request</th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::post() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . Util::toJson($value) . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">GET Request</th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::get() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . Util::toJson($value) . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Query (<span class="text-danger"><?php echo count(BenchmarkManager::query()); ?></span>)</th>
                        <td>
                            <?php
                            $i = 0;
                            foreach (BenchmarkManager::query() as $query) {
                                $i++;
                                echo '<label class="text-info">{' . Formatter::toIndoNumber($query[execution_time], 7) . ' Seconds}</label> ' . $query['sql'] . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Total Query Execute Time</th>
                        <td><strong class="text-info"><?php echo Formatter::toIndoNumber(BenchmarkManager::totalExecutionQuery(), 7) . ' Seconds'; ?></strong></td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Memory Used</th>
                        <td><strong class="text-info"><?php echo BenchmarkManager::memory(); ?></strong></td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Real Memory Used</th>
                        <td><strong class="text-info"><?php echo BenchmarkManager::realMemory(); ?></strong></td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success">Rendered Time</th>
                        <td><strong class="text-info"><?php echo Formatter::toIndoNumber(BenchmarkManager::render(), 7) . ' Seconds'; ?></strong></td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success" width="190">Session</th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::session() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . Util::toJson($value) . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="info text-right text-success" width="190">Server Information</th>
                        <td>
                            <?php
                            foreach (BenchmarkManager::getServerInfo() as $key => $value) {
                                echo '<label class="text-info">{' . $key . '}</label> ' . $value . '<br>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>