<?php

namespace App\Constants;

class PromptConst
{
    //Prompt to generate text
    public static function generateTextPrompt(string $topic, string $level): string
    {
        return "Buat materi pembelajaran sekolah tentang topik: {$topic}. untuk tingkat pendidikan: {$level}.
                Gunakan bahasa yang sederhana, jelas, dan ramah untuk siswa.
                Jelaskan konsep secara bertahap, mulai dari definisi dasar hingga penerapan praktis.
                Sertakan beberapa analogi sederhana yang berkaitan dengan kehidupan sehari-hari siswa.
                Jika sesuai, tambahkan contoh singkat atau soal latihan.
                Gunakan nada edukatif dan bersahabat.
                Gunakan format Markdown yang lengkap, termasuk bold untuk istilah penting dan heading untuk setiap bagian.
                Struktur materi:

                1. Pendahuluan
                2. Konsep Utama
                3. Contoh dan Analogi
                4. Penerapan Sehari-hari
                5. Soal Latihan
                6. Kesimpulan

                Penting: Tulis seluruh konten dalam Bahasa Indonesia.";
    }
}
