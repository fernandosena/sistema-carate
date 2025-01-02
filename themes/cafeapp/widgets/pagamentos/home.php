<?php $this->layout("_theme"); ?>

<section class="app_launch_box">
    <?php if (!$payments): ?>
        <?php if (empty($filter->status)): ?>
            <div class="message info icon-info">Ainda não existe pagamentos
                gerados .
            </div>
        <?php else: ?>
            <div class="message info icon-info">Não existem pagamentos para o filtro aplicado.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <table class="app_launch_table">
            <thead>
                <th>Valor</th>
                <th>Qtd Alunos</th>
                <th>Cadastro</th>
            </thead>
            <tbody>
                <?php
                    foreach ($payments as $payment):
                ?>
                    <tr>
                        <td>R$ <?= number_format($payment->value, 2, ',', '.') ?></td>
                        <td><?= $payment->qtd_alunos ?></td>
                        <td><?= $payment->created_at ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
