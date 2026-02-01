<?php

namespace App\Agents;

use App\Tools\ImageGenerations\InfographicsGeneration;
use Vizra\VizraADK\Agents\BaseLlmAgent;

class ImageGenerationAgent extends BaseLlmAgent
{
    protected string $name = 'Agen Pembuat Gambar';
    protected string $description = 'Agen yang dikhususkan untuk membuat gambar infografis.';

    protected string $instructions = 'Tugas utama Anda adalah menjalankan tool "infographics_generation".
    DILARANG membuat data gambar sendiri.
    Gunakan parameter "description" dari user dan "reference_id" yang diberikan.
    Setelah tool memberikan hasil, kembalikan HANYA string JSON dari tool tersebut tanpa tambahan teks apapun dan TANPA format markdown (backticks).';

    protected string $model = 'gemini-2.0-flash-exp';

    protected array $tools = [
        InfographicsGeneration::class,
    ];
}
