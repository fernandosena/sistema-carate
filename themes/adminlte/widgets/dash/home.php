<?php $this->layout("_admin"); ?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3><?= $quantity["teachers"] ?></h3>
                <p>Instrutores</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/instructors/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $quantity["black"] ?></h3>
                <p>Dan</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= url("admin/students/all/black/home/all") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
        <div class="inner">
            <h3><?= $quantity["kyus"] ?></h3>
            <p>Kyus</p>
        </div>
        <div class="icon">
            <i class="ion ion-person"></i>
        </div>
        <a href="<?= url("admin/students/all/kyus/home/all") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
        <div class="inner">
            <h3><?= $quantity["belts"] ?></h3>
            <p>Graduações</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="<?= url("admin/belts/home") ?>" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="div col-md-12">
        <!-- BAR CHART -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relátorio Alunos e instrutores</h3>
            </div>
            <div class="card-header">
                <div class="d-block card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#chart" data-toggle="tab">Gŕafico</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#instrutores" data-toggle="tab">Instrutores</a>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="yearChart">Ano</label>
                            <select class="custom-select form-control-border" id="yearChart" data-url="<?= url("admin/chart/quantity") ?>" data-filter="1">
                                <?php 
                                    $yeaNow = (int) date("Y");
                                    for($i = 2024; $i <= $yeaNow; $i++):
                                ?>
                                <option value="<?= $i ?>" <?= ($i == $yeaNow) ? "selected" : null ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="monthChart">Mês</label>
                            <select class="custom-select form-control-border" id="monthChart" data-url="<?= url("admin/chart/quantity") ?>" data-filter="1">
                                <?php 
                                    $monthNow = (int) date("m");
                                    $meses = arrayMonthRanger();
                                    foreach($meses as $key => $value):
                                ?>
                                <option value="<?= $key ?>" <?= ($key == $monthNow) ? "selected" : null ?>><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="filterChart"></label>
                            <button type="button" id="atualizar" class="btn btn-block btn-primary">Atualizar</button>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="chart"
                       style="position: relative; height: 300px;">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="instrutores" style="position: relative; height: 300px;">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cadastro</th>
                            </tr>
                        </thead>
                        <tbody id="instrutorestable">
                            <?php foreach ($table["instrutores"] as $t): ?>
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
    <div class="div col-md-12">
        <div class="card  card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Avisos
                </h3>
            </div>

            <div class="card-body">
                <?php if(!empty($info["instructors"]) || !empty($info["black"])): ?>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data da graduação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($info["instructors"])): ?>
                                <?php foreach ($info["instructors"] as $instructors): ?>
                                <tr>
                                    <td><a href="<?= url("/admin/instructors/instructor/{$instructors->id}"); ?>"><?= $instructors->fullName(); ?></a></td>
                                    <td><?= date_fmt($instructors->next_graduation, "d/m/Y"); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if(!empty($info["black"])): ?>
                                <?php foreach ($info["black"] as $black):?>
                                <tr>
                                    <td><a href="<?= url("/admin/students/black/student/{$black->id}"); ?>"><?= $black->fullName(); ?></a></td>
                                    <td><?= date_fmt($black->next_graduation, "d/m/Y"); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Data da graduação</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Alerta!</h5>
                        Nenhum aviso encontrado
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->start("scripts"); ?>
<script>
    window.label = [<?= implode(",", array: array_map(function($dia) {
        return "'" . $dia . "'";
    }, arrayDaysRanger() ?? [])) ?>];
    window.instrutores = [<?= implode(",", $amount_month["instrutores"] ?? []) ?>];
    window.dan = [<?= implode(",", $amount_month["dan"] ?? []) ?>];
    window.kyus = [<?= implode(",", $amount_month["kyus"] ?? []) ?>];

    $(function () {
        let myChart;
        $("#atualizar").on("click",function (e) {
            e.preventDefault();

            var year = $("#yearChart")
            var month = $("#monthChart")

            var data = year.data();
            var load = $(".ajax_load");

            $.ajax({
                url: data.url,
                type: "POST",
                data: { year: year.val(), month: month.val(), filter: data.filter },
                dataType: "json",
                beforeSend: function () {
                    load.fadeIn(200).css("display", "flex");
                },
                success: function (data) {
                    if (data.result) {
                        if (data.label) {
                            window.label = Object.values(data.label);
                        }
                        if (data.result.instrutores) {
                            window.instrutores = Object.values(data.result.instrutores);
                        }
                        if (data.result.dan) {
                            window.dan = Object.values(data.result.dan);
                        }
                        if (data.result.kyus) {
                            window.kyus = Object.values(data.result.kyus);
                        }
                        chart(window.label, window.instrutores, window.dan, window.kyus)
                    }

                    if(data.table){
                        if(data.table.instrutores){
                            console.log(data.table.instrutores)
                            $("#instrutorestable").empty();
                            $.each(data.table.instrutores, function (index, item) {
                                let row = $("<tr>"); // Cria a linha <tr>

                                // Adiciona as células <td> com os dados do item
                                row.append($("<td>").text(item.name)); // Exemplo: adiciona o nome
                                row.append($("<td>").text(item.created_at)); // Exemplo: adiciona a idade
                                
                                // Adicione outras células conforme necessário, acessando as propriedades do seu objeto 'item'

                                $("#instrutorestable").append(row); // Adiciona a linha à tabela
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
        function chart(l, i, d, k){
            var areaChartData = {
                labels: l,
                datasets: [
                {
                    label: "Instrutores",
                    backgroundColor: "rgba(23,162,184,0.9)",
                    borderColor: "rgba(60,141,188,0.8)",
                    pointRadius: false,
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: i,
                },
                {
                    label: "Dan",
                    backgroundColor: "rgba(255, 193, 7,0.9)",
                    borderColor: "rgba(210, 214, 222, 1)",
                    pointRadius: false,
                    pointColor: "rgba(210, 214, 222, 1)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: d,
                },
                {
                    label: "Kyus",
                    backgroundColor: "rgba(40, 167, 69, 1)",
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
        chart(window.label, window.instrutores, window.dan, window.kyus);
    });
</script>
<?php $this->end(); ?>