<?php $this->layout("_admin"); ?>

<div class="row">
    <div class="div col-md-12">
        <div class="card card-warning" 
        data-card-id="1">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i> Upload Documentos
                </h3>
            </div>

            <div class="card-body">
                
            <form class="app_form" enctype="multipart/form-data" action="<?= url("admin/documents") ?>" method="post">
                <input type="hidden" name="type" value="create">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Arquivo PDF</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                    <input type="file" accept=".pdf" class="custom-file-input" id="exampleInputFile" name="archive">
                                    <label class="custom-file-label" for="exampleInputFile">Escolher arquivo</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>*Titulo</label>
                                <input type="text"
                                name="title" class="form-control" placeholder="Titulo" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="div col-md-12">
        <!-- BAR CHART -->
        <div class="card card-primary"  
        data-card-id="2">
            <div class="card-header">
                <h3 class="card-title">Arquivos</h3>
            </div>
            <div class="card-body">
                <?php if(!empty($archives)): ?>
                    <div class="div_archives">
                        <?php foreach($archives as $archive): ?>
                            <div>
                                <iframe src="<?= url("storage/{$archive->archive}") ?>" width="150" height="150" style="border: none;"></iframe>
                                <a href="<?= url("storage/{$archive->archive}") ?>" target="__black">
                                    <h2><?= $archive->title ?></h2>
                                </a>
                                <a href="#" class="btn bg-danger"
                                data-post="<?= url("admin/documents") ?>"
                                data-type="delete"
                                data-confirm="ATENÇÃO: Tem certeza que deseja DELETAR esse arquivo?"
                                data-id="<?= $archive->id; ?>"><i class="fa-solid fa-trash"></i> Excluir</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible">
                        Nenhum arquivo enviado
                    </div>
                <?php endif ?>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>