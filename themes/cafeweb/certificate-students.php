<?php $this->layout("_theme"); ?>

<div class="al-center"><?= flash(); ?></div>
<article class="auth">
    <div class="container-tap">
        <div class="content-tap">
            <h1>Escolha o aluno</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td>
                                <a href="<?= url("certificado/{$student->document}/app/{$student->id}") ?>">
                                    <?= $student->fullName() ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</article>