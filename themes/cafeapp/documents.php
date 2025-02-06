<?php $this->layout("_theme"); ?>

<ul class="app_formbox app_widget">
    <h2 class="icon-bar-chart">Documentos</h2>
        <?php if(!empty($documents)): ?>
        <div class="div_archives">
          <?php foreach($documents as $document):?>
            <div>
                <iframe src="<?= url("storage/{$document->archive}") ?>" width="150" height="150" style="border: none;"></iframe>
                <h2><?= $document->title ?></h2>
                <a href="<?= url("storage/{$document->archive}") ?>" target="__black" download="">
                    <button class="btn bg-success">Baixar PDF</button>
                </a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
          <div class="message info icon-warning alert alert-warning alert-dismissible" style="margin-top: 10px">Nenhum documento cadastrado</div>
      <?php endif; ?>
</div>