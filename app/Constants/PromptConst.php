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

    //Prompt to generate image
    public static function generateImagePrompt(string $description): string
    {
        return "Buat gambar yang menggambarkan: {$description}.
                Gaya gambar harus cerah, menarik, dan sesuai untuk materi pembelajaran sekolah.
                Gunakan warna-warna yang hidup dan elemen visual yang mudah dipahami oleh siswa.
                Pastikan gambar tersebut relevan dengan topik pembelajaran dan dapat membantu pemahaman siswa.
                Ukuran file maksimal 5MB.
                Gunakan resolusi sedang.
                Desain harus profesional namun tetap menarik untuk siswa.";
    }

    //Prompt to generate Infographic
    public static function generateInfographicPrompt(string $topic): string{
        return "Buat infografis edukatif tentang topik: {$topic}.
                Infografis harus:
                - Menggunakan layout yang terstruktur dengan judul yang jelas
                - Berisi poin-poin penting dalam bentuk visual yang mudah dipahami
                - Menggunakan ikon, diagram, atau ilustrasi sederhana untuk menjelaskan konsep
                - Menggunakan warna-warna cerah dan menarik untuk siswa
                - Menampilkan informasi dalam bentuk hierarki yang jelas
                - Menggunakan Bahasa Indonesia
                - Cocok untuk ditampilkan di kelas atau bahan belajar siswa
                - Ukuran file maksimal 5MB
                - Gunakan resolusi sedang
                Desain harus profesional namun tetap menarik untuk siswa.";
    }

    //Prompt to generate Poster
    public static function generatePosterPrompt(string $topic): string{
        return "Buat poster edukatif tentang topik: {$topic}.
                Poster harus:
                - Memiliki judul yang besar dan menarik perhatian
                - Mengandung pesan edukatif yang jelas dan mudah diingat
                - Menggunakan ilustrasi atau gambar yang mendukung tema pendidikan
                - Menggunakan tipografi yang mudah dibaca
                - Menggunakan kombinasi warna yang harmonis dan eye-catching
                - Cocok untuk dipajang di dinding kelas atau ruang belajar
                - Menggunakan Bahasa Indonesia
                - Memiliki komposisi visual yang seimbang
                - Ukuran file maksimal 5MB
                - Gunakan resolusi sedang
                Desain harus inspiratif dan memotivasi siswa untuk belajar.";
    }

    //Prompt to generate Basic Vector
    public static function generateBasicVectorPrompt(string $subject): string{
        return "Buat ilustrasi vektor sederhana tentang: {$subject}.
                Ilustrasi harus:
                - Menggunakan bentuk-bentuk dasar dan garis yang bersih
                - Memiliki palet warna terbatas yang cerah dan menarik
                - Menampilkan subjek dengan cara yang mudah dikenali dan dipahami
                - Menggunakan gaya minimalis namun tetap estetis
                - Cocok untuk digunakan dalam materi pembelajaran atau presentasi
                - Menggunakan Bahasa Indonesia
                - Gunakan resolusi sedang
                - Ukuran file maksimal 5MB
                Desain harus profesional namun tetap sederhana dan efektif.";
    }

    // Prompt to generate Realistic Image
    public static function generateRealisticImagePrompt(string $subject): string
    {
        return "Buat gambar fotorealistik tentang: {$subject}.
                Gambar harus terlihat nyata seperti foto asli dengan pencahayaan alami, detail tekstur yang tajam, dan kedalaman ruang (depth of field) yang baik.
                Pastikan subjek terlihat edukatif dan tidak menakutkan bagi siswa.
                Gunakan resolusi sedang, ukuran file maksimal 5MB, dan komposisi yang bersih layaknya fotografi profesional.";
    }

    // Prompt to generate 3D Rendered Image
    public static function generate3DRenderedPrompt(string $subject): string
    {
        return "Buat gambar gaya 3D Render (seperti gaya animasi modern/Pixar) tentang: {$subject}.
                Gunakan pencahayaan lembut (soft lighting), karakter atau objek dengan sudut yang halus (rounded edges), dan warna-warna pastel yang cerah.
                Tampilan harus terlihat bersih, modern, dan memiliki dimensi volume yang jelas.
                Gunakan resolusi sedang, ukuran file maksimal 5MB, dan desain yang ramah anak.";
    }

    // Prompt to generate Sketch Pencil Drawing
    public static function generateSketchPencilPrompt(string $subject): string
    {
        return "Buat gambar sketsa pensil hitam putih tentang: {$subject}.
                Gunakan teknik arsir yang detail, garis-garis sketsa yang artistik namun tetap jelas menunjukkan struktur objek.
                Gaya gambar harus menyerupai ilustrasi buku teks sains atau seni klasik yang digambar tangan.
                Fokus pada kejelasan bentuk edukatif.
                Gunakan resolusi sedang dan ukuran file maksimal 5MB.";
    }

    // Prompt to generate Cartoon Style Image
    public static function generateCartoonStylePrompt(string $subject): string
    {
        return "Buat ilustrasi gaya kartun yang ceria tentang: {$subject}.
                Gunakan garis tepi (outline) yang tegas, ekspresi yang ramah, dan warna-warna yang sangat hidup (vibrant).
                Karakter atau objek harus terlihat ekspresif dan menyenangkan untuk menarik perhatian siswa sekolah dasar.
                Gunakan resolusi sedang, ukuran file maksimal 5MB, dan komposisi visual yang dinamis.";
    }

    // Prompt to generate Watercolor Painting Style Image
    public static function generateWatercolorPrompt(string $subject): string
    {
        return "Buat lukisan cat air (watercolor) tentang: {$subject}.
                Gunakan tekstur kertas yang terlihat lembut, perpaduan warna yang transparan, dan tepian warna yang artistik (bleeding effect).
                Gaya harus terlihat tenang, estetis, dan memberikan kesan seni yang inspiratif bagi siswa.
                Gunakan resolusi sedang, ukuran file maksimal 5MB, dan palet warna yang harmonis.";
    }
}
