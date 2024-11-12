<?php $this->layout("_theme"); ?>

<div class="al-center"><?= flash(); ?></div>
<article class="auth">
    <div class="container-tap">
        <div>
            <h1>Escolha o aluno</h1>
            <table style="margin: 10px auto 0 auto;">
                <thead>
                    <tr>
                        <th>Alunos</th>
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