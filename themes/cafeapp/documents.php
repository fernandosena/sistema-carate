<?php $this->layout("_theme"); ?>

<ul class="app_formbox app_widget">
    <h2 class="icon-bar-chart">Documentos</h2>
    <ul class="timeline">
        <?php if(!empty($documents)): ?>
          <?php foreach($documents as $document):?>
              <li>
                  a
              </li>
          <?php endforeach; ?>
      <?php else: ?>
          <div class="message info icon-warning alert alert-warning alert-dismissible" style="margin-top: 10px">Nenhum documento cadastrado</div>
      <?php endif; ?>
    </ul>
</div>