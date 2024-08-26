<?php

namespace App\Services;

use App\Models\Agenda;
use Exception;

class AgendaService{
    
    public function store($request, $fk_estabelecimento)
    {
        try{
            foreach($request as $day){
                $agenda = new Agenda();
                $agenda->fill($day);
                $agenda->fk_estabelecimento = $fk_estabelecimento;
                $agenda->save();                
            }

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function update($agendas, $idEstabelecimento)
    {
        try{
            Agenda::where('fk_estabelecimento', $idEstabelecimento)->delete();
            
            foreach($agendas as $agenda){
                $new = new Agenda();
                
                $new->fill($agenda);
                $new->fk_estabelecimento = $idEstabelecimento;
                $new->save();
            }

            return response()->json(null, 201);

        }catch(Exception $e){
            throw $e;
        }
    }
}