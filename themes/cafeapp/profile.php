<?php $this->layout("_theme"); ?>

<div class="app_formbox app_widget">
    <form class="app_form" method="post">
        <input type="hidden" name="update" value="true"/>

        <div class="app_formbox_photo">
            <div class="rounded j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-user">Nome:</span>
                <input class="radius" type="text" name="first_name" required
                       value="<?= $user->first_name; ?>" readonly/>
            </label>

            <label>
                <span class="field icon-user-plus">Sobrenome:</span>
                <input class="radius" type="text" name="last_name" required
                       value="<?= $user->last_name; ?>" readonly/>
            </label>
        </div>

        <label>
            <span class="field icon-briefcase">Genero:</span>
            <select name="genre" readonly disabled required>
                <option value="">Selecione</option>
                <option <?= ($user->genre == "male" ? "selected" : ""); ?> value="male">&ofcir; Masculino</option>
                <option <?= ($user->genre == "female" ? "selected" : ""); ?> value="female">&ofcir; Feminino</option>
                <option <?= ($user->genre == "other" ? "selected" : ""); ?> value="other">&ofcir; Outro</option>
            </select>
        </label>

        <div class="label_group">
            <label>
                <span class="field icon-calendar">Nascimento:</span>
                <input class="radius mask-date" type="text" name="datebirth" placeholder="dd/mm/yyyy" readonly required
                       value="<?= ($user->datebirth ? date_fmt($user->datebirth, "d/m/Y") : null); ?>"/>
            </label>

            <label>
                <span class="field icon-briefcase">CPF:</span>
                <input class="radius mask-doc" type="text" name="document" placeholder="Apenas números" readonly required
                       value="<?= $user->document; ?>"/>
            </label>
        </div>

        <label>
            <span class="field icon-envelope">E-mail:</span>
            <input class="radius" type="email" readonly name="email" placeholder="Seu e-mail de acesso" readonly
                   value="<?= $user->email; ?>"/>
        </label>
    </form>
</div>