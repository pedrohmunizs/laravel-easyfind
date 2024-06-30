<?php

namespace App\Services;

use App\Models\Agenda;

class AgendaService{
    
    public function store($request, $fk_estabelecimento)
    {
        foreach($request as $day){
            $agenda = new Agenda();
            $agenda->fill($day);
            $agenda->fk_estabelecimento = $fk_estabelecimento;
            $agenda->save();

            return $agenda;
        }
    }
}