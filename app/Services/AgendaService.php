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

    public function update($agendas, $idEstabelecimento)
    {
        Agenda::where('fk_estabelecimento', $idEstabelecimento)->delete();

        foreach($agendas as $agenda){
            $new = new Agenda();

            $new->fill($agenda);
            $new->fk_estabelecimento = $idEstabelecimento;
            $new->save();
        }
        return response()->json(null, 201);
    }
}