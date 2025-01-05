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
    <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Quantidade de alunos - <?= date("Y") ?></h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
    $(function () {
        //-------------
        //- BAR CHART -
        //-------------
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
                data: [<?= implode(",", $amount_month["dan"] ?? []) ?>],
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
                data: [<?= implode(",", $amount_month["kyus1"] ?? []) ?>],
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
                data: [<?= implode(",", $amount_month["kyus2"] ?? []) ?>],
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

        new Chart(barChartCanvas, {
            type: "bar",
            data: barChartData,
            options: barChartOptions,
        });
    });
</script>
<?php $this->end(); ?>