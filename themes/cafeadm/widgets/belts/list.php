<?php $this->layout("_admin"); ?>
<?php $this->insert("widgets/belts/sidebar"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-user">Faixas</h2>
        <form action="<?= url("/admin/belts/home"); ?>" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar faixa:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>

    <div class="dash_content_app_box">
        <section>
            <div class="app_users_home">
                <?php foreach ($belts as $belt): ?>
                    <article class="user radius">
                        <h4 style="background-color: <?= $belt->color ?>; padding:  7px; border-radius: 10px;"><?= $belt->title; ?></h4>
                        <div class="info">
                            <p>Desde <?= date_fmt($belt->created_at, "d/m/y \à\s H\hi"); ?></p>
                            <p><?= str_limit_words($belt->description, 5)?></p>
                        </div>

                        <div class="actions">
                            <a class="icon-cog btn btn-blue" href="<?= url("/admin/belts/list/{$belt->id}"); ?>"
                               title="Listar Alunos">Listar Alunos</a>
                            <a class="icon-cog btn btn-blue" href="<?= url("/admin/belts/belt/{$belt->id}"); ?>"
                               title="Gerênciar">Gerenciar</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?= $paginator; ?>
        </section>
    </div>
</section>