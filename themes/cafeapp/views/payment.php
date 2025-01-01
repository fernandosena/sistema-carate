<div class="app_modal_box app_modal_payment">
    <p class="title icon-calendar-check-o">Novo Pagamento</p>
    <form class="app_form div_pix" action="<?= url("/app/pagamentos/gerar"); ?>" method="post">
        <div class="label_group">
            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" required/>
            </label>
            <label>
                <span class="field icon-user">Quantiade de alunos</span>
                <input class="radius" type="number" name="students" required/>
            </label>

        </div>
        <button class="btn radius transition icon-check-square-o">Gerar código PIX</button>
    </form>
</div>