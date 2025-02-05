<div class="app_modal" data-modalclose="true">
    <!--INCOME-->
    <?php
        $user = user();
        $wallets = (new \Source\Models\App\AppWallet())
            ->find("user_id = :u", "u={$user->id}", "id, wallet")
            ->order("wallet")
            ->fetch(true);

        $this->insert("views/invoice", [
            "type" => "income",
            "wallets" => $wallets,
            "categories" => (new \Source\Models\App\AppCategory())
                ->find("type = :t", "t=income", "id, name")
                ->order("order_by, name")
                ->fetch(true)
        ]);

        $this->insert("views/invoice", [
            "type" => "expense",
            "wallets" => $wallets,
            "categories" => (new \Source\Models\App\AppCategory())
                ->find("type = :t", "t=expense", "id, name")
                ->order("order_by, name")
                ->fetch(true)
        ]);

        $this->insert("views/student", [
            "graduations" => (new \Source\Models\Belt())
                ->find("title LIKE '%IOGKF%' OR title LIKE '%dan (%'")
                ->order("title")
                ->fetch(true)
        ]);

        $this->insert("views/kyus");

        $this->insert("views/payment");
    ?>
    <!--SUPPORT-->
    <div class="app_modal_box app_modal_contact">
        <p class="title icon-calendar-minus-o">Fale conosco:</p>
        <form class="app_form" action="<?= url("/app/support"); ?>" method="post">
            <label>
                <span class="field icon-life-ring">O que precisa?</span>
                <select name="subject" required>
                    <option value="Pedido de suporte">&ofcir; Preciso de suporte</option>
                    <option value="Tranferir aluno">&ofcir; Trânferir aluno</option>
                    <option value="Nova sugestão">&ofcir; Enviar uma sugestão</option>
                    <option value="Nova reclamação">&ofcir; Enviar uma reclamação</option>
                    <option value="Outro">&ofcir; Outro</option>
                </select>
            </label>

            <label>
                <span class="field icon-comments-o">Mensagem:</span>
                <textarea class="radius" name="message" rows="4" required></textarea>
            </label>

            <button class="btn radius transition icon-paper-plane-o">Enviar Agora</button>
        </form>
    </div>

    <div class="app_modal_box app_modal_student_belt">
        <?php if(!empty($student) && $student->status != "pending"): ?>
            <p class="title icon-user">Alterar Graduação:</p>
            <form class="app_form" action="<?= url("/app/alunos/faixa"); ?>" method="post">
                <input type="hidden" name="action" value="update"/>
                <input type="hidden" name="id" value="<?= $student->id ?>"/>
                <input type="hidden" name="type" value="<?= $type ?>">
                <label>
                    <span class="field icon-filter">Graduação: </span>
                    <select name="graduation" required>
                        <?php foreach ($belts as $belt): ?>
                            <?php if($belt->id !== $student->belts): ?>
                                <option value="<?= $belt->id; ?>">&ofcir; <?= $belt->title; ?> - <?= $belt->description; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <span class="field icon-text">Observação:</span>
                    <textarea class="radius" name="description" placeholder="Aluno passou para a faixa XYZ" required></textarea>
                </label>

                <button class="btn radius transition icon-check-square-o">Atualizar troca de Graduação</button>
            </form>
        <?php else: ?>
            <div class="message warning icon-warning">
                o aluno ainda está em análise, tente novamente mais tarde
            </div>
        <?php endif; ?>
    </div>

    <div class="app_modal_box app_modal_student_renew">
        <p class="title icon-user">Subir de graduação:</p>
        <form class="app_form" action="<?= url("/app/alunos/faixa"); ?>" method="post">
            <input type="hidden" name="action" value="update-graduation"/>
            <input type="hidden" class="app_modal_student_renew_type" name="type" value="">
            <input type="hidden" class="app_modal_student_renew_id" name="id" value="">
            <div class="app_modal_student_renew_graduations">
                <label>
                    <span class="field icon-filter">Graduação: </span>
                    <select name="graduation" required>
                        <?php 
                            $graduations = (new \Source\Models\Belt())->find("type_student = :t", "t={$type}")->fetch(true);
                        ?>
                        <?php foreach ($graduations as $belt): ?>
                            <?php if($belt->id !== $student->belts): ?>
                                <option value="<?= $belt->id; ?>">&ofcir; <?= $belt->title; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <label>
                <span class="field icon-text">Data da graduação:</span>
                <input type="date" class="radius" name="date" required></t>
            </label>
            <button class="btn radius transition icon-check-square-o">Atualizar Graduação</button>
        </form>
    </div>


    <div class="app_modal_box app_modal_student_transfer">
        <p class="title icon-user">Tranferir Aluno:</p>
        <form class="app_form" action="<?= url("/app/transfer"); ?>" method="post">      
            <input type="hidden" name="id" value="<?= $student->id ?>"/>    
            <input type="hidden" name="type" value="<?= $type ?>">   
            <input type="hidden" name="action" value="create">
            <label>
                <span class="field icon-status">Dojo:</span>
                <select name="dojo">
                    <option value="activated">&ofcir; --- Selecione um Dojo ---</option>
                    <?php if(!empty($teachers)): ?>
                        <?php foreach($teachers as $teacher): ?>
                            <?php foreach (explode(",", $teacher->dojo) as $dojo): ?>
                                <option value="<?= "{$teacher->id}|{$dojo}" ?>">&ofcir; <?= "{$dojo} - {$teacher->fullName()}" ?></option>
                            <?php endforeach; ?>  
                        <?php endforeach; ?>    
                    <?php endif; ?>
                </select>
            </label>

            <button class="btn radius transition icon-check-square-o">Tranferir</button>
        </form>
    </div>
</div>