<?php
namespace Source\Support;
use Fpdf\Fpdf;

class Certificate {
    protected $pdf;
    protected $name;
    protected $dataName = [
        "font" => "Arial",
        "size" => 30,
        "x"=> 20,
        "y"=> 100,
        "w"=> 265,
        "h"=> 10,
        "border" => '',
        "align" => "C",
        "fill" => 0,
        "color" => [
            "r" => 0,
            "g" => 0,
            "b" => 0
        ]
    ];
    protected $date;
    protected $dataDate = [
        "font" => "Arial",
        "size" => 15,
        "x"=> 130,
        "y"=> 172,
        "w"=> 165,
        "h"=> 10,
        "border" => '',
        "align" => "C",
        "fill" => 0,
        "color" => [
            "r" => 0,
            "g" => 0,
            "b" => 0
        ]
    ];
    protected $cpf;
    protected $model;

    function __construct($name, $date, $cpf, $model)
    {
        $this->pdf = new Fpdf();
        $this->name = $name;
        $this->date = $date;
        $this->cpf = $cpf;
        $this->model = $model;
    }

    function setColorName($r = 0, $g = 0, $b = 0){
        $this->dataName["color"] = [
            "r" => $r,
            "g" => $g,
            "b" => $b,
        ];
        return $this;
    }

    function setSizeName($size = 30){
        $this->dataName["size"] = $size;
        return $this;
    }

    function setXYName($x = 20, $y = 100){
        $this->dataName["x"] = $x;
        $this->dataName["y"] = $y;
        return $this;
    }
    function setNameMultiCell($w = 265, $h = 10, $border = '', $align = "C", $fill = 0){
        $this->dataName["w"] = $w;
        $this->dataName["h"] = $h;
        $this->dataName["border"] = $border;
        $this->dataName["align"] = $align;
        $this->dataName["fill"] = $fill;
        return $this;
    }
    
    function setColorDate($r = 0, $g = 0, $b = 0){
        $this->dataDate["color"] = [
            "r" => $r,
            "g" => $g,
            "b" => $b,
        ];
        return $this;
    }

    function setSizeDate($size = 30){
        $this->dataDate["size"] = $size;
        return $this;
    }

    function setXYDate($x = 150, $y = 172){
        $this->dataDate["x"] = $x;
        $this->dataDate["y"] = $y;
        return $this;
    }

    function setDateMultiCell($w = 265, $h = 10, $border = '', $align = "C", $fill = 0){
        $this->dataDate["w"] = $w;
        $this->dataDate["border"] = $border;
        $this->dataDate["align"] = $align;
        $this->dataDate["h"] = $h;
        $this->dataDate["fill"] = $fill;
        return $this;
    }
    

    public function render() 
    {
        $this->pdf->AddPage('L');

        $this->pdf->SetLineWidth(1.5);

        // desenha a imagem do certificado
        $this->pdf->Image($this->model,0,0,295);

        // Mostrar o nome
        $this->pdf->SetFont($this->dataName["font"], '', $this->dataName["size"]);
        $this->pdf->SetTextColor($this->dataName["color"]["r"], $this->dataName["color"]["g"], $this->dataName["color"]["b"]);
        $this->pdf->SetXY($this->dataName["x"],$this->dataName["y"]);
        $this->pdf->MultiCell($this->dataName["w"], $this->dataName["h"], $this->name, $this->dataName["border"], $this->dataName["align"], $this->dataName["fill"]);

        
        $this->pdf->SetFont($this->dataDate["font"], '', $this->dataDate["size"]);
        $this->pdf->SetTextColor($this->dataDate["color"]["r"], $this->dataDate["color"]["g"], $this->dataDate["color"]["b"]);
        $this->pdf->SetXY($this->dataDate["x"],$this->dataDate["y"]);
        $this->pdf->MultiCell($this->dataDate["w"], $this->dataDate["h"], $this->date, $this->dataDate["border"], $this->dataDate["align"], $this->dataDate["fill"]);

        $this->pdf->Output('Certificado_'.$this->cpf.'.pdf','I');
        return;
    }   
}
?>