<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class IdeaGenerationController extends Controller
{
    public function index(): View
    {
        return view('idea_generation.index');
    }

    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:2000',
        ]);

        try {
            // Simulate AI processing delay
            sleep(1);

            // Generate AI response
            $response = $this->generateAIResponse($request->prompt);

            return response()->json([
                'success' => true,
                'response' => $response,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            Log::error('AI Generation Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Maaf, terjadi kesalahan saat menghasilkan ide. Silakan coba lagi.',
            ], 500);
        }
    }

    public function generateImage(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:2000',
            'art_style' => 'nullable|string|in:realistic,anime,cartoon,digital-art,oil-painting,watercolor,3d-render,pixel-art',
        ]);

        try {
            // Simulate AI image processing delay
            sleep(2);

            // Generate AI image with art style
            $artStyle = $request->input('art_style', 'realistic');
            $imageData = $this->generateAIImage($request->prompt, $artStyle);

            return response()->json([
                'success' => true,
                'image_url' => $imageData['url'],
                'prompt' => $request->prompt,
                'art_style' => $artStyle,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            Log::error('AI Image Generation Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Maaf, terjadi kesalahan saat menghasilkan gambar. Silakan coba lagi.',
            ], 500);
        }
    }

    protected function generateAIResponse(string $prompt): string
    {
        // This is a placeholder implementation
        // TODO: Integrate with actual AI service (Gemini, OpenAI, Claude, etc.)
        
        $templates = [
            'pembelajaran' => "Berdasarkan topik '{$prompt}', berikut beberapa ide pembelajaran yang dapat diterapkan:\n\n" .
                "1. **Metode Interaktif**: Gunakan pendekatan hands-on learning dengan aktivitas praktis yang melibatkan siswa secara langsung.\n\n" .
                "2. **Pembelajaran Berbasis Proyek**: Buat proyek kolaboratif yang memungkinkan siswa mengeksplorasi topik secara mendalam.\n\n" .
                "3. **Teknologi Pendukung**: Manfaatkan aplikasi edukatif dan media digital untuk membuat pembelajaran lebih menarik.\n\n" .
                "4. **Gamifikasi**: Implementasikan elemen permainan untuk meningkatkan motivasi dan partisipasi siswa.",
            
            'proyek' => "Ide proyek untuk '{$prompt}':\n\n" .
                "**Tahap Perencanaan:**\n" .
                "- Identifikasi tujuan dan hasil yang diharapkan\n" .
                "- Tentukan tim dan pembagian tugas\n" .
                "- Buat timeline dan milestone\n\n" .
                "**Eksekusi:**\n" .
                "- Implementasi bertahap dengan review berkala\n" .
                "- Dokumentasi proses dan hasil\n" .
                "- Evaluasi dan perbaikan berkelanjutan",
            
            'default' => "Terima kasih atas pertanyaan Anda tentang '{$prompt}'.\n\n" .
                "**Berikut beberapa ide kreatif:**\n\n" .
                "1. **Analisis Mendalam**: Pelajari aspek fundamental dari topik ini dan identifikasi area kunci yang perlu difokuskan.\n\n" .
                "2. **Pendekatan Inovatif**: Eksplorasi metode-metode baru dan non-konvensional yang dapat memberikan perspektif berbeda.\n\n" .
                "3. **Kolaborasi & Sinergi**: Libatkan berbagai stakeholder untuk mendapatkan masukan dan dukungan yang komprehensif.\n\n" .
                "4. **Implementasi Praktis**: Buat rencana aksi yang konkret dan terukur untuk merealisasikan ide-ide tersebut.\n\n" .
                "💡 **Tip**: Mulai dengan langkah kecil dan lakukan iterasi berdasarkan feedback yang didapat!"
        ];

        $lowerPrompt = strtolower($prompt);
        
        if (str_contains($lowerPrompt, 'pembelajaran') || str_contains($lowerPrompt, 'belajar') || str_contains($lowerPrompt, 'mengajar')) {
            return $templates['pembelajaran'];
        } elseif (str_contains($lowerPrompt, 'proyek') || str_contains($lowerPrompt, 'project')) {
            return $templates['proyek'];
        } else {
            return $templates['default'];
        }
    }

    protected function generateAIImage(string $prompt, string $artStyle = 'realistic'): array
    {
        // This is a placeholder implementation
        // TODO: Integrate with actual AI image service (DALL-E, Stable Diffusion, Midjourney, etc.)
        
        // Map art styles to additional keywords for better placeholder results
        $styleKeywords = [
            'realistic' => 'photo,realistic',
            'anime' => 'anime,illustration',
            'cartoon' => 'cartoon,drawing',
            'digital-art' => 'digital,art',
            'oil-painting' => 'painting,art',
            'watercolor' => 'watercolor,painting',
            '3d-render' => '3d,render,cgi',
            'pixel-art' => 'pixel,retro,8bit',
        ];
        
        $styleKeyword = $styleKeywords[$artStyle] ?? 'art';
        $keywords = urlencode($prompt . ' ' . $styleKeyword);
        $seed = crc32($prompt . $artStyle);
        
        // Using Unsplash Source API with random seed based on prompt and style
        $imageUrl = "https://source.unsplash.com/800x600/?{$keywords}&sig={$seed}";
        
        return [
            'url' => $imageUrl,
            'prompt' => $prompt,
            'art_style' => $artStyle,
            'seed' => $seed,
        ];
    }
}
