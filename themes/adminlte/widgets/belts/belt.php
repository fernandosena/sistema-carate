<?php $this->layout("_admin"); ?>

<section class="dash_content_app">
    <?php if (!$belt): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= (!empty($belt)) ? $belt->title : "Criar nova faixa"; ?></h3>
            </div>
            <form class="app_form" action="<?= url("/admin/belts/belt/{$belt->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="create"/>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>*Titulo</label>
                                <input type="text"
                                name="title"  class="form-control" placeholder="Titulo" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Faixa etaria</label>
                                <select name="age_range" class="form-control">
                                    <option value="1">Até 12 anos</option>
                                    <option value="2">A partir de 13 anos</option>
                                    <option value="3">Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Posição na graduação</label>
                                <select name="position" class="form-control">
                                    <option value="">=== Nenhum ===</option>
                                    <?php for($i = 1;$i <= 20; $i ++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar Graduação</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $belt->title; ?></h3>
            </div>
            <form class="app_form" action="<?= url("/admin/belts/belt/{$belt->id}"); ?>" method="post">
                <div class="card-body">
                    <!--ACTION SPOOFING-->
                    <input type="hidden" name="action" value="update"/>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>*Titulo</label>
                                <input type="text"
                                name="title" value="<?= $belt->title; ?>" class="form-control" placeholder="Titulo" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Faixa etaria</label>
                                <?php
                                    $age_range = $belt->age_range;
                                    $select = function ($value) use ($age_range) {
                                        return ($age_range == $value ? "selected" : "");
                                    };
                                ?>
                                <select name="age_range" class="form-control">
                                    <option value="1" <?= $select("1"); ?>>Até 12 anos</option>
                                    <option value="2" <?= $select("2"); ?>>A partir de 13 anos</option>
                                    <option value="3" <?= $select("3"); ?>>Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Posição na graduação</label>
                                <select name="position" class="form-control">
                                    <option value="">=== Nenhum ===</option>
                                    <?php for($i = 1;$i <= 20; $i ++): ?>
                                        <option value="<?= $i ?>" <?= ($belt->position == $i) ? "selected" : null ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar Graduação</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>