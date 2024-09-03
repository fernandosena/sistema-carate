<?php $this->layout("_admin"); ?>
<?php $this->insert("widgets/belts/sidebar"); ?>

<section class="dash_content_app">
    <?php if (!$belt): ?>
        <header class="dash_content_app_header">
            <h2 class="icon-plus-circle">Nova Faixa</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/belts/belt"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="create"/>
                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Titulo:</span>
                        <input type="text" name="title" placeholder="Titulo" required/>
                    </label>
                    <label class="label">
                        <span class="legend">*Cor:</span>
                        <input type="color" name="color" placeholder="Cor" required/>
                    </label>
                </div>
                <label class="label">
                    <span class="legend">Descrição:</span>
                    <textarea name="description" placeholder="Descrição"></textarea>
                </label>
                <div class="al-right">
                    <button class="btn btn-green icon-check-square-o">Criar Faixa</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <header class="dash_content_app_header">
            <h2 class="icon-user"><?= $belt->title; ?></h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/belts/belt/{$belt->id}"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="update"/>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Title:</span>
                        <input type="text" name="title" value="<?= $belt->title; ?>"
                               placeholder="Titulo" required/>
                    </label>

                    <label class="label">
                        <span class="legend">*Cor:</span>
                        <input type="color" name="color" value="<?= $belt->color; ?>" required/>
                    </label>
                </div>

                <label class="label">
                    <span class="legend">Descrição:</span>
                    <textarea name="description"><?= $belt->description; ?></textarea>
                </label>
                <div class="app_form_footer">
                    <button class="btn btn-blue icon-check-square-o">Atualizar</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>