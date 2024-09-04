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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Titulo</label>
                                <input type="text"
                                name="title"  class="form-control" placeholder="Titulo" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Cor:</label>
                                <input type="color"
                                name="color" class="form-control" placeholder="Cor" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea name="description" class="form-control" placeholder="Descrição da faixa"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Criar Faixa</button>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Titulo</label>
                                <input type="text"
                                name="title" value="<?= $belt->title; ?>" class="form-control" placeholder="Titulo" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>*Cor:</label>
                                <input type="color"
                                name="color" value="<?= $belt->color; ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea name="description" class="form-control" placeholder="Descrição da faixa"><?= $belt->description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar Faixa</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>