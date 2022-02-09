<?php

namespace App\Clase;

class InformatiiProduse {
    public $Serie;
    public $Denumire;
    private $Detalii = [
        'Produs1'  => [
            'serie'     => 'P1',
            'denumire'  => 'Produsul de asigurare 1'
        ],
        'Produs2'  => [
            'serie'     => 'P2',
            'denumire'  => 'Produsul de asigurare 2'
        ]
    ];

    public function __construct($produs)
    {
        $this->Serie = $this->Detalii[$produs]['serie'];
        $this->Denumire = $this->Detalii[$produs]['denumire'];
    }
}

?>