<?php

namespace App\Enums;

enum StatusPedido: string
{
    case Pendente = 'pendente';
    case EmPreparo = 'em_preparo';
    case AguardadoRetirada = 'aguardando_retirada';
    case Cancelado = 'cancelado';
    case Finalizado = 'finalizado';
}
