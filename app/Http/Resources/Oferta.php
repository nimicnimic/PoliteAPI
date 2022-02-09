<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Oferta extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->IdOferta,
            'serie' => $this->Serie,
            'numar' => $this->Numar,
            'dataEmitere' => $this->DataEmitere->format('d.m.Y'),
            'dataStart' => $this->DataStart->format('d.m.Y'),
            'dataEnd' => $this->DataEnd->format('d.m.Y'),
            'prima' => $this->Prima,
            'sumaAsigurata' => $this->SumaAsigurata,
            'valuta' => $this->Valuta,
            'pachet' => $this->PachetAsigurare,
            'campOptional' => $this->Optional,
            'created_at' => $this->created_at->format('d.m.Y'),
            'updated_at' => $this->updated_at->format('d.m.Y'),
        ];
    }
}
