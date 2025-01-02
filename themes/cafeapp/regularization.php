<?php $this->layout("_theme"); ?>
<article class="app_signature radius">
    <header class="app_signature_header gradient gradient-green">
        <h2>Regulariação!</h2>
        <p>Realize aregularização da sua matricula!</p><br>
        <?php
            $budges = false;
            $btnOptions = false;
            $btnCancel = false;
            $lastPayment = $user->paymentsPendingLast();

            //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
            $paymentsActivatedLast = $user->paymentsActivatedLast();

            if(!$lastPayment){
                if($paymentsActivatedLast){
                    $budges = verify_renew($paymentsActivatedLast->created_at);
                }else{
                    $budges = verify_renew($user->created_at);
                }
                if($budges){
                    $btnOptions = true;
                }
            }else{
                $dataPayment = new DateTime($lastPayment->created_at);
                $now = new DateTime();
                $diferenca = $now->diff($dataPayment);

                if($diferenca->days <= 0){
                    $btnCancel = true;
                }
            }
        ?>
        <?php if($btnOptions): ?>
            <a href="#" class="btn bg-success"
            data-post="<?= url("app/regularization") ?>"
            data-action="payment"
            data-type="create"
            data-user_id="<?= $user->id; ?>"><i class="fa-solid fa-circle-check"></i> Informar Pagamento</a>
        <?php endif; ?>
        <?php  if($btnCancel): ?>
            <a href="#" class="btn bg-warning"
            data-post="<?= url("app/regularization") ?>"
            data-action="payment"
            data-type="cancel"
            data-user_id="<?= $user->id; ?>"><i class="fa-solid fa-circle-check"></i> Cancelar </a>
        <?php endif; ?>
        <?php  if(!$budges && !$btnCancel && !$btnOptions): ?>
            Atualizado
        <?php endif; ?>
    </header>
</article>