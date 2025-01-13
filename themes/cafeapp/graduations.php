<?php $this->layout("_theme"); ?>

<ul class="app_formbox app_widget">
    <h2 class="icon-bar-chart">Suas graduações</h2>
    <ul class="timeline">
        <?php if(!empty($historics)): ?>
          <?php $c=0; foreach($historics as $historic):?>
              <?php if($historic->status == "disapprove"){continue;} ?>
              <?php  if($historic->status == "approved" && $c == 0){$c = 1;} ?>
              <li <?= ($c == 1) ? 'class="active"': null?>>
                  <?php $data = $historic->findBelt($historic->graduation_id) ?>
                  <h6><?= $data->title ?><?= ($historic->status == "pending") ? " - <span class='badge bg-warning'>Em Análise</span>" : (($historic->status == "disapprove") ? " - <span class='badge bg-danger'>Reprovado</span>" : null) ; ?></h6>
                  <p class="mb-0 text-muted"><?= $historic->description ?></p>
                  <p class="text-muted"><?= (!empty($historic->date)) ? date_fmt($historic->date, "d/m/Y") : date_fmt($historic->created_at, "d/m/Y"); ?></p>
              </li>
          <?php if($c == 1){$c = 2;} endforeach; ?>
      <?php else: ?>
          <div class="message info icon-warning alert alert-warning alert-dismissible">Nenhum histórico encontrado</div>
      <?php endif; ?>
    </ul>
</div>