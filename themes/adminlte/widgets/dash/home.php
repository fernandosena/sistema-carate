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
        <div class="card card-warning <?= ($_COOKIE["card_state_1"] === '') ? 'collapsed-card' : null ?>" 
        data-card-id="1">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Avisos
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                  data-url="<?= url("/admin/card"); ?>">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
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
    <div class="div col-md-12">
        <!-- BAR CHART -->
        <div class="card card-primary <?= ($_COOKIE["card_state_2"] === '') ? 'collapsed-card' : null ?>"  
        data-card-id="2">
            <div class="card-header">
                <h3 class="card-title">Relátorio de Afiliações</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                  data-url="<?= url("/admin/card"); ?>">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <div class="d-block card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#chart" data-toggle="tab">Gŕafico</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#instrutores" data-toggle="tab">Instrutores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dan" data-toggle="tab">Dan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#kyus" data-toggle="tab">Kyus</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="yearChart">Intrutores</label>
                            <select class="custom-select form-control-border" id="instructorChart">
                                <option value="all">Todos</option>
                                <?php 
                                    foreach($instructors as $instructor):
                                ?>
                                <option value="<?= $instructor->id ?>"><?= $instructor->fullName() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="yearChart">Ano</label>
                            <select class="custom-select form-control-border" id="yearChart" data-url="<?= url("admin/chart/quantity/A") ?>" data-filter="1">
                                <?php 
                                    $yeaNow = (int) date("Y");
                                    for($i = 2024; $i <= $yeaNow; $i++):
                                ?>
                                <option value="<?= $i ?>" <?= ($i == $yeaNow) ? "selected" : null ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="monthChart">Mês</label>
                            <select class="custom-select form-control-border" id="monthChart" data-url="<?= url("admin/chart/table/affiliation") ?>" data-filter="1">
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
                  <div class="tab-pane" id="instrutores" style="position: relative">
                    <table id="tableIntructorAjax" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <div class="tab-pane" id="dan" style="position: relative">
                    <table id="tableDanAjax" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div><div class="tab-pane" id="kyus" style="position: relative">
                    <table id="tableKyusAjax" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card card-success <?= ($_COOKIE["card_state_3"] === '') ? 'collapsed-card' : null ?>"  
        data-card-id="3">
            <div class="card-header">
                <h3 class="card-title">Relátorio de Graduação</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                  data-url="<?= url("/admin/card"); ?>">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <div class="d-block card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#chartG" data-toggle="tab">Gŕafico</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#instrutoresG" data-toggle="tab">Instrutores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#danG" data-toggle="tab">Dan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#kyusG" data-toggle="tab">Kyus</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="instructorChartG">Intrutores</label>
                            <select class="custom-select form-control-border" id="instructorChartG">
                                <option value="all">Todos</option>
                                <?php 
                                    foreach($instructors as $instructor):
                                ?>
                                <option value="<?= $instructor->id ?>"><?= $instructor->fullName() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="yearChartG">Ano</label>
                            <select class="custom-select form-control-border" id="yearChartG" data-url="<?= url("admin/chart/quantity/G") ?>" data-filter="1">
                                <?php 
                                    $yeaNow = (int) date("Y");
                                    for($i = 2024; $i <= $yeaNow; $i++):
                                ?>
                                <option value="<?= $i ?>" <?= ($i == $yeaNow) ? "selected" : null ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="monthChartG">Mês</label>
                            <select class="custom-select form-control-border" id="monthChartG" data-url="<?= url("admin/chart/table/graduation") ?>" data-filter="1">
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
                            <label for="atualizarG"></label>
                            <button type="button" id="atualizarG" class="btn btn-block btn-primary">Atualizar</button>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="chartG"
                       style="position: relative; height: 300px;">
                        <canvas id="barChartG" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                   </div>
                  <div class="tab-pane" id="instrutoresG" style="position: relative">
                    <table id="tableIntructorAjaxG" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <div class="tab-pane" id="danG" style="position: relative">
                    <table id="tableDanAjaxG" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div><div class="tab-pane" id="kyusG" style="position: relative">
                    <table id="tableKyusAjaxG" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Graduação</th>
                                <th>Data</th>
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
</div>
<?php $this->start("scripts"); ?>
<script>
    $(function () {
        function reloadTable(code = '') {
            console.log('#tableIntructorAjax'+code)
            $('#tableIntructorAjax'+code).DataTable().ajax.reload()
            $('#tableDanAjax'+code).DataTable().ajax.reload()
            $('#tableKyusAjax'+code).DataTable().ajax.reload()
        }

        function atualizar(chartId, yearId, monthId, instructorId){
            var year = $(yearId)
            var month = $(monthId)

            var data = year.data();
            var load = $(".ajax_load");
            console.log(data.url);

            $.ajax({
                url: data.url,
                type: "POST",
                data: { year: year.val(), month: month.val(), filter: data.filter, instructor: $(instructorId).val() },
                dataType: "json",
                beforeSend: function () {
                    load.fadeIn(200).css("display", "flex");
                },
                success: function (data) {
                    if (data.result) {
                        if (data.label) {
                            label = Object.values(data.label);
                        }
                        if (data.result.instrutores) {
                            instrutores = Object.values(data.result.instrutores);
                        }
                        if (data.result.dan) {
                            dan = Object.values(data.result.dan);
                        }
                        if (data.result.kyus) {
                            kyus = Object.values(data.result.kyus);
                        }
                        chart(chartId,label, instrutores, dan, kyus)
                    }
                    load.fadeOut();
                },
                error: function () {
                    load.fadeOut();
                },
            });
        }
        
        $("#atualizar").on("click",function (e) {
            e.preventDefault();
            reloadTable();
            atualizar("#barChart", "#yearChart", "#monthChart", "#instructorChart");
        });

        $("#atualizarG").on("click",function (e) {
            e.preventDefault();
            reloadTable("G");
            atualizar("#barChartG", "#yearChartG", "#monthChartG", "#instructorChartG");
        });

        function chart(chartId, l, i, d, k){
            var chart = chartId.replace(/^#|\./g, "");
            if (window.charts && window.charts[chart]) {
                window.charts[chart].destroy();
            }

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

            var barChartCanvas = $(chartId).get(0).getContext("2d");
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
                    yAxes: [{ 
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {if (value % 1 === 0) {return value;}}
                        }
                    }]
                }
            };
         
            
            if (!window.charts) {
                window.charts = {};
            }

            window.charts[chart] = new Chart(barChartCanvas, {
                type: "bar",
                data: barChartData,
                options: barChartOptions,
            });
        }
        
        chart(
            "#barChart",
            [<?= implode(",", array: array_map(function($dia) {
                return "'" . $dia . "'";
            }, arrayDaysRanger() ?? [])) ?>],
            [<?= implode(",", $amount_days["instrutores"] ?? []) ?>],
            [<?= implode(",", $amount_days["dan"] ?? []) ?>],
            [<?= implode(",", $amount_days["kyus"] ?? []) ?>]
        );
        
        chart(
            "#barChartG",
            [<?= implode(",", array: array_map(function($dia) {
                return "'" . $dia . "'";
            }, arrayDaysRanger() ?? [])) ?>],
            [<?= implode(",", $amount_days["instrutoresG"] ?? []) ?>],
            [<?= implode(",", $amount_days["danG"] ?? []) ?>],
            [<?= implode(",", $amount_days["kyusG"] ?? []) ?>]
        );

        function table(table, type, instructorId, yearId, monthId, code = false){
            var optionTable = {
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                language: {
                    search: "Pequisar",
                    searchPlaceholder: "Digite a sua pesquisa aqui...",
                    zeroRecords: "Nenhum registro correspondente encontrado",
                    emptyTable: "Não há dados disponíveis na tabela",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                    infoFiltered: "(filtrado do total de _MAX_ entradas)",
                    loadingRecords: "Carregando...",
                    buttons: {
                    copy: "Copiar",
                    copyTitle: "Dados copiados",
                    copySuccess: {
                        _: "%d linhas copiadas",
                        1: "1 linha copiada",
                    },
                    copyKeys:
                        "Pressione Ctrl+C para copiar os dados para a área de transferência",
                        csv: "CSV",
                        excel: "Excel",
                        pdf: "PDF",
                        print: "Imprimir",
                        colvis: "Colunas",
                    },
                    paginate: {
                        first: "Primeiro",
                        last: "Último",
                        next: "Próximo",
                        previous: "Anterior",
                    },
                    aria: {
                        orderable: "Ordenar por esta coluna",
                        orderableReverse: "Ordem inversa desta coluna",
                    },
                },
                pageLength: 100,
                "processing": true,
                "serverSide": true,
            };

            if(code){
                optionTable["columns"] = [
                    { "data": "name" },
                    { "data": "graduation" },
                    { "data": "created_at"},
                ];
            }else{
                optionTable["columns"] = [
                    { "data": "name" },
                    { "data": "created_at"},
                ];
            }


            $(table).DataTable({
                ...optionTable,
                "ajax": {
                    "url": $(monthId).data('url'),
                    "type": "POST",
                    "data": function(d) {
                        d.year = $(yearId).val();
                        d.month = $(monthId).val();
                        d.filter = $(yearId).data('filter');
                        d.instructor = $(instructorId).val();
                        d.type = type;
                    }
                }
            })
            .buttons()
            .container()
            .appendTo("#example1_wrapper .col-md-6:eq(0)");
        }
        
        table(
            "#tableIntructorAjax",
            'intructor', 
            '#instructorChart',
            '#yearChart',
            '#monthChart'
        );

        table(
            "#tableDanAjax",
            'black',
            '#instructorChart',
            '#yearChart',
            '#monthChart'
        );

        table(
            "#tableKyusAjax",
            'kyus',
            '#instructorChart',
            '#yearChart',
            '#monthChart'
        );

        table(
            "#tableIntructorAjaxG",
            'intructor', 
            '#instructorChartG',
            '#yearChartG',
            '#monthChartG',
            "G"
        );

        table(
            "#tableDanAjaxG",
            'black',
            '#instructorChartG',
            '#yearChartG',
            '#monthChartG',
            "G"
        );

        table(
            "#tableKyusAjaxG",
            'kyus',
            '#instructorChartG',
            '#yearChartG',
            '#monthChartG',
            "G"
        );
    });
</script>
<?php $this->end(); ?>