<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $table = "Oferte";
    protected $primaryKey = "IdOferta";
    protected $fillable = ['Serie', 'Numar', 'DataEmitere', 'DataStart', 'DataEnd', 'Prima', 'SumaAsigurata', 'Valuta', 'PachetAsigurare', 'Optional'];
    // trebuie specificate coloanele de tip date, altfel apeluri de forma $this->DataEmitere->format("d.m.Y") dau eroare pt ca vede $this->DataEmitere ca fiind string
    protected $dates = ['DataEmitere', 'DataStart', 'DataEnd'];
}
