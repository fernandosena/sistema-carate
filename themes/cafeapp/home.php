<?php $this->layout("_theme"); ?>
    <div class="app_main_box">
        <section class="app_main_left">
            <article class="app_widget">
                <header class="app_widget_title">
                    <h2 class="icon-bar-chart">Controle de alunos</h2>
                </header>
                <div id="control"></div>
            </article>

        </section>

        <section class="app_main_right">
            <ul class="app_widget_shortcuts">
                <li class="income radius transition" data-modalopen=".app_modal_student">
                    <p class="icon-plus-circle">Faixa Preta</p>
                </li>
                <li class="income radius transition" data-modalopen=".app_modal_student_kyus">
                    <p class="icon-plus-circle">KYUS</p>
                </li>
            </ul>

            <article
                    class="app_flex app_wallet <?= ($wallet->balance == "positive" ? "gradient-green" : "gradient-red"); ?>">
                <header class="app_flex_title">
                    <h2 class="icon-user radius">Alunos Cadastrados</h2>
                </header>

                <p class="app_flex_amount"><?= $studentscount ?? 0 ?></p>
            </article>

            <section class="app_widget app_widget_blog">
                <header class="app_widget_title">
                    <h2 class="icon-info">Avisos:</h2>
                </header>
                <div class="app_widget_content">
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $notice): ?>
                            <article class="app_widget_blog_article">
                                <div class="thumb">
                                    <strong class="badge bg-warning">Atualização de aluno</strong>
                                </div>
                                <h3 class="title">O aluno
                                    <a href="<?= url("app/aluno/{$notice->type}/{$notice->id}"); ?>"
                                       title="<?= $notice->title; ?>"><?= $notice->fullName() ?></a> precisa ser atualizado. O mesmo já é maior de 18 anos
                                </h3>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="message info icon-info">
                            Não existem nenhum aviso ainda.
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </section>
    </div>

<?php $this->start("scripts"); ?>
    <script type="text/javascript">
        $(function () {
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.'
                }
            });

            var chart = Highcharts.chart('control', {
                chart: {
                    type: 'areaspline',
                    spacingBottom: 0,
                    spacingTop: 5,
                    spacingLeft: 0,
                    spacingRight: 0,
                    height: (9 / 16 * 100) + '%'
                },
                title: null,
                xAxis: {
                    categories: [<?= $chart->categories; ?>],
                    minTickInterval: 1
                },
                yAxis: {
                    allowDecimals: true,
                    title: null,
                },
                tooltip: {
                    shared: true,
                    valueDecimals: 0,
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.5
                    }
                },
                series: [{
                    name: 'Alunos',
                    data: [<?= $chart->students;?>],
                    color: '#61DDBC',
                    lineColor: '#36BA9B'
                }]
            });
        });
    </script>
<?php $this->end(); ?>