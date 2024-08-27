<?php

namespace App\Jobs;

use App\Models\Imagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SaveImageProdutoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $idProduto;
    /**
     * Create a new job instance.
     */
    public function __construct($path, $idProduto)
    {
        $this->path = $path;
        $this->idProduto = $idProduto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imageContent = Storage::disk('public')->get($this->path);
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        $imageName = md5(pathinfo($this->path, PATHINFO_FILENAME) . strtotime("now")) . '.' . $extension;
        $destinationPath = public_path('img/produtos/') . $imageName;
        file_put_contents($destinationPath, $imageContent);

        $imagem = new Imagem();
        $imagem->nome_referencia = $imageName;
        $imagem->nome_imagem = pathinfo($this->path, PATHINFO_BASENAME);
        $imagem->fk_produto = $this->idProduto;
        $imagem->save();

        Storage::disk('public')->delete($this->path);
    }
}
