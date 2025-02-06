<?php

namespace Source\App\Admin;

use Source\Models\App\AppArchives;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class Documents
 * @package Source\App\Admin
 */
class Documents extends Admin
{
    /**
     * Documents constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        if(!empty($data)){
            if($data["type"] == "create"){
                $archives = (new AppArchives());
                $archives->title = $data["title"];
    
                //upload archive
                $files = $_FILES["archive"];
                $upload = new Upload();
                $archive = $upload->file($files, $data["title"]);
    
                if (!$archive) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
    
                $archives->archive = $archive;
    
                if(!$archives->save()){
                    $json["message"] = $archives->message()->render();
                    echo json_encode($json);
                    return;
                }
    
                $this->message->success("Upload de arquivo realizado com sucesso!")->flash();
                $json["reload"] = true;
                echo json_encode($json);
                return;
            }


            if($data["type"] == "delete"){
                $archives = (new AppArchives())->findById($data['id']);
                if (!$archives) {
                    $json["message"] = $this->message->warning("O Arquivo informado não foi encontrado")->render();
                    echo json_encode($json);
                    return;
                }

                if(!$archives->destroy()){
                    $json["message"] = $archives->message()->render();
                    echo json_encode($json);
                    return;
                }
                
                $this->message->success("O Arquivo foi deletado com sucesso")->flash();
                $json["reload"] = true;
                echo json_encode($json);
                return;
            }
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Documentos",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/documents/home", [
            "app" => "documents",
            "head" => $head,
            "archives" => (new AppArchives())->find()->fetch(true)
        ]);
    }
}