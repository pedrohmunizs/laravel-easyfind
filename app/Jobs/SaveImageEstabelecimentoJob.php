<?php

namespace App\Jobs;

use App\Models\Imagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SaveImageEstabelecimentoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imagePath;
    protected $idEstabelecimento;

    /**
     * Create a new job instance.
     */
    public function __construct($imagePath, $idEstabelecimento)
    {
        $this->imagePath = $imagePath;
        $this->idEstabelecimento = $idEstabelecimento;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imageContent = Storage::disk('public')->get($this->imagePath);
        $extension = pathinfo($this->imagePath, PATHINFO_EXTENSION);
        $imageName = md5(pathinfo($this->imagePath, PATHINFO_FILENAME) . strtotime("now")) . '.' . $extension;
        $destinationPath = public_path('img/estabelecimentos/') . $imageName;
        file_put_contents($destinationPath, $imageContent);

        $imagem = new Imagem();
        $imagem->nome_referencia = $imageName;
        $imagem->nome_imagem = pathinfo($this->imagePath, PATHINFO_BASENAME);
        $imagem->fk_estabelecimento = $this->idEstabelecimento;
        $imagem->save();

        Storage::disk('public')->delete($this->imagePath);
    }
}
