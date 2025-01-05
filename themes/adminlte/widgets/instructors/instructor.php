<?php $this->layout("_admin"); ?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $students["dan"]["count"] ?></h3>
                <p>Dan</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/students/{$user->id}/black/home/all") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
        <div class="inner">
            <h3><?= $students["kyu1"]["count"] ?></h3>
            <p>Kyus até 12 anos</p>
        </div>
        <div class="icon">
            <i class="ion ion-person"></i>
        </div>
        <a href="<?= url("admin/students/{$user->id}/kyus/home/menor") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
        <div class="inner">
            <h3><?= $students["kyu2"]["count"] ?></h3>
            <p>Kyus a partir de 13 anos</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="<?= url("admin/students/{$user->id}/kyus/home/maior") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= ($user->first_name) ? str_limit_chars($user->first_name, 15): "Instrutor" ?></h3>
                <p>Perfil</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/instructors/instructor/{$user->id}/profile") ?>" class="small-box-footer">Editar <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="div col-md-6">
    <!-- BAR CHART -->
    <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relátorio Alunos </h3>
            </div>
            <div class="card-header">
                <div class="d-block card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#chart" data-toggle="tab">Gŕafico</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#dan" data-toggle="tab">Dan</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#kyu1" data-toggle="tab">Kyus até 12 anos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#kyu2" data-toggle="tab">Kyus a partir de 13 anos</a>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="filterChart">Filtro ano</label>
                            <select class="custom-select form-control-border" id="filterChart" data-url="<?= url("admin/chart/quantity") ?>" data-filter="2" data-user="<?= $user->id ?>">
                                <?php 
                                    $yeaNow = (int) date("Y");
                                    for($i = 2024; $i <= $yeaNow; $i++):
                                ?>
                                <option value="<?= $i ?>" <?= ($i == $yeaNow) ? "selected" : null ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <div class="chart tab-pane" id="dan">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </thead>
                            <tbody id="danstable">
                                <?php foreach ($table["dan"] as $t): ?>
                                    <tr>
                                        <td>
                                            <?= $t->fullname() ?>
                                        </td>
                                        <td>
                                            <?= date("d/m/Y", strtotime($t->created_at)) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="chart tab-pane" id="kyu1">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </thead>
                            <tbody id="kyu1table">
                                <?php foreach ($table["kyu1"] as $t): ?>
                                    <tr>
                                        <td>
                                            <?= $t->fullname() ?>
                                        </td>
                                        <td>
                                            <?= date("d/m/Y", strtotime($t->created_at)) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="chart tab-pane" id="kyu2">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </thead>
                            <tbody id="kyu2table">
                                <?php foreach ($table["kyu2"] as $t): ?>
                                    <tr>
                                        <td>
                                            <?= $t->fullname() ?>
                                        </td>
                                        <td>
                                            <?= date("d/m/Y", strtotime($t->created_at)) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cadastro</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="div col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Todos os Pagamentos do instrutor
                </h3>
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cadastro</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= $payment->id ?></td>
                        <td><?= date("d/m/Y H:m:s", strtotime($payment->created_at)) ?></td>
                        <td><?= $payment->status ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Cadastro</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>
<?php $this->start("scripts"); ?>
<script>
    window.i = [<?= implode(",", $amount_month["dan"] ?? []) ?>];
    window.d = [<?= implode(",", $amount_month["kyus1"] ?? []) ?>];
    window.k = [<?= implode(",", $amount_month["kyus2"] ?? []) ?>];

    $(function () {
        let myChart;
        $("#filterChart").change(function (e) {
            e.preventDefault();

            var data = $(this).data();
            var load = $(".ajax_load");

            $.ajax({
                url: data.url,
                type: "POST",
                data: { year: $(this).val(), filter: data.filter, user: data.user },
                dataType: "json",
                beforeSend: function () {
                    load.fadeIn(200).css("display", "flex");
                },
                success: function (data) {
                    if (data.result) {
                        if (data.result.i) {
                            window.i = Object.values(data.result.i);
                        }
                        if (data.result.d) {
                            window.d = Object.values(data.result.d);
                        }
                        if (data.result.k) {
                            window.k = Object.values(data.result.k);
                        }
                        chart(window.i, window.d, window.k)
                    }

                    if(data.table){
                        if(data.table.dan){
                            $("#danstable").empty();
                            $.each(data.table.dan, function (index, item) {
                                let row = $("<tr>"); // Cria a linha <tr>

                                // Adiciona as células <td> com os dados do item
                                row.append($("<td>").text(item.name)); // Exemplo: adiciona o nome
                                row.append($("<td>").text(item.created_at)); // Exemplo: adiciona a idade
                                
                                // Adicione outras células conforme necessário, acessando as propriedades do seu objeto 'item'

                                $("#danstable").append(row); // Adiciona a linha à tabela
                            });
                        }
                        if(data.table.kyu1){
                            $("#kyu1table").empty();
                            $.each(data.table.kyu1, function (index, item) {
                                let row = $("<tr>"); // Cria a linha <tr>

                                // Adiciona as células <td> com os dados do item
                                row.append($("<td>").text(item.name)); // Exemplo: adiciona o nome
                                row.append($("<td>").text(item.created_at)); // Exemplo: adiciona a idade
                                
                                // Adicione outras células conforme necessário, acessando as propriedades do seu objeto 'item'

                                $("#kyu1table").append(row); // Adiciona a linha à tabela
                            });
                        }
                        if(data.table.kyu1){
                            $("#kyu2table").empty();
                            $.each(data.table.kyu2, function (index, item) {
                                let row = $("<tr>"); // Cria a linha <tr>

                                // Adiciona as células <td> com os dados do item
                                row.append($("<td>").text(item.name)); // Exemplo: adiciona o nome
                                row.append($("<td>").text(item.created_at)); // Exemplo: adiciona a idade
                                
                                // Adicione outras células conforme necessário, acessando as propriedades do seu objeto 'item'

                                $("#kyu2table").append(row); // Adiciona a linha à tabela
                            });
                        }
                    }

                    load.fadeOut();
                },
                error: function () {
                    load.fadeOut();
                },
            });
        });


        //-------------
        //- BAR CHART -
        //-------------
        function chart(i, d, k){
            var areaChartData = {
                labels: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setebro",
                "Outubro",
                "Novembro",
                "Dezembro",
                ],
                datasets: [
                    {
                        label: "Dan",
                        backgroundColor: "rgba(255, 193, 7,0.9)",
                        borderColor: "rgba(60,141,188,0.8)",
                        pointRadius: false,
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: i,
                    },
                    {
                        label: "Kyus até 12 anos",
                        backgroundColor: "rgba(40, 167, 69, 1)",
                        borderColor: "rgba(210, 214, 222, 1)",
                        pointRadius: false,
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: d,
                    },
                    {
                        label: "Kyus a partir de 13 anos",
                        backgroundColor: "rgba(220, 53, 69, 1)",
                        borderColor: "rgba(210, 214, 222, 1)",
                        pointRadius: false,
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: k,
                    },
                ],
            };

            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var barChartData = $.extend(true, {}, areaChartData);
            var temp0 = areaChartData.datasets[0];
            barChartData.datasets[0] = temp0;

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    y: { // Para Chart.js v3+
                        beginAtZero: true, // Começa o eixo Y em 0
                        ticks: {
                            stepSize: 1, // Define o intervalo entre os ticks como 1
                            precision: 0, // Remove casas decimais dos ticks
                            callback: function(value) { if (value % 1 === 0) { return value; } } // Exibe apenas números inteiros
                        }
                    },
                    yAxes: [{ // Para Chart.js v2 (se você estiver usando uma versão antiga)
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {if (value % 1 === 0) {return value;}}
                        }
                    }]
                }
            };
         
            if (myChart) {
                myChart.destroy();
            }
         
            myChart = new Chart(barChartCanvas, {
                type: "bar",
                data: barChartData,
                options: barChartOptions,
            });
        }
        chart(window.i, window.d, window.k);
    });
</script>
<?php $this->end(); ?>