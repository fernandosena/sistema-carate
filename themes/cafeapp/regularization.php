<?php $this->layout("_theme"); ?>
<article class="app_signature radius">
    <header class="app_signature_header gradient gradient-green">
        <h2>Regulariação!</h2>
        <p>Realize aregularização da sua matricula!</p><br>

        <?php
            $verify = verify_renew(user()->last_renewal_data);
            if($verify && (user()->renewal != "pending")){
        ?>
            <a href="#" class="btn bg-success"
            data-post="<?= url("app/regularization") ?>"
            data-action="payment"
            data-user_id="<?= user()->id; ?>"><i class="fa-solid fa-circle-check"></i> Realizar o Pagamento</a>
        <?php
            }else{
                if(user()->renewal == "pending"){
                    echo "Em analise";
                }else{
                    echo "Usuário atualizado";
                }
            }
        ?>
    </header>
</article>