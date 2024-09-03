<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/faixas</h3>
    <p class="dash_content_sidebar_desc">Gerencietodas as faixas aqui...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($app) {
            $active = ($app == $href ? "active" : null);
            $url = url("/admin/{$href}");
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"{$url}\">{$title}</a>";
        };

        echo $nav("user", "belts/home", "Faixas");
        echo $nav("plus-circle", "belts/belt", "Nova faixa");
        ?>

        <?php if (!empty($user) && $user->photo()): ?>
            <img class="radius" style="width: 100%; margin-top: 30px" src="<?= image($user->photo, 600, 600); ?>"/>
        <?php endif; ?>
    </nav>
</div>