<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua data yang mungkin dikirim dari form
        $validated = $request->validate([
            // Aturan untuk Portfolio
            'title'         => 'required|string|max:150',
            'description'   => 'nullable|string',
            'theme'         => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk foto profil

            // Aturan untuk Project (sebagai array)
            'projects'      => 'nullable|array',
            'projects.*.title' => 'required_with:projects|string|max:150',
            'projects.*.description' => 'nullable|string',
            'projects.*.technologies' => 'required_with:projects|string',
            'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar proyek boleh kosong, berupa teks, maksimal 255 karakter
            'projects.*.project_link' => 'nullable|url',

            // Aturan untuk Experience (sebagai array)
            'experiences'   => 'nullable|array',
            'experiences.*.company' => 'required_with:experiences|string|max:100',
            'experiences.*.position' => 'required_with:experiences|string|max:100',
            'experiences.*.start_date' => 'required_with:experiences|date',
            'experiences.*.end_date' => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.description' => 'nullable|string',

            // Aturan untuk Education (sebagai array)
            'educations'    => 'nullable|array',
            'educations.*.institution' => 'required_with:educations|string|max:150',
            'educations.*.degree' => 'required_with:educations|string|max:100',
            'educations.*.start_year' => 'required_with:educations|digits:4',
            'educations.*.end_year' => 'nullable|digits:4|gte:educations.*.start_year',
            'educations.*.description' => 'nullable|string',

            // Aturan untuk Skill (sebagai array)
            'skills'        => 'nullable|array',
            'skills.*.skill_name' => 'required_with:skills|string|max:100',
            'skills.*.level' => 'required_with:skills|in:Beginner,Intermediate,Expert',

            // Aturan untuk Social Link (sebagai array)
            'social_links'  => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|max:50',
            'social_links.*.url' => 'required_with:social_links|url',
        ]);

        // 2. Bungkus semua dalam satu Database Transaction
        DB::transaction(function () use ($request, $validated) {
            $user_id = Auth::id();

            $portfolioData = [
                'user_id'     => $user_id,
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'theme'       => $validated['theme'],
                'slug'        => Str::slug($validated['title']) . '-' . $user_id,
            ];

            // Handle profile image saat create
            if ($request->hasFile('profile_image')) {
                $portfolioData['profile_image_path'] = $request->file('profile_image')->store('profile_images', 'public');
            }

            // Buat entitas utama: Portfolio
            $portfolio = Portfolio::create($portfolioData);


            // --- PERBAIKAN DI SINI ---
            // Logika untuk menyimpan Project diubah dari createMany() menjadi perulangan
            // agar bisa memproses file gambar satu per satu.

            if (!empty($validated['projects'])) {
                foreach ($validated['projects'] as $index => $projectData) {
                    // Cek apakah ada file gambar untuk proyek ini
                    if ($request->hasFile("projects.{$index}.image")) {
                        // Simpan file dan ganti isi 'image' dengan path-nya
                        $projectData['image'] = $request->file("projects.{$index}.image")->store('project_images', 'public');
                    }
                    // Buat record proyek yang berelasi dengan portfolio
                    $portfolio->projects()->create($projectData);
                }
            }

            // 3. Gunakan pola yang sama untuk menyimpan setiap data relasi

            // Simpan Projects jika ada datanya
            // if (!empty($validated['projects'])) {
            //     $portfolio->projects()->createMany($validated['projects']);
            // }

            // Simpan Experiences jika ada datanya
            if (!empty($validated['experiences'])) {
                $portfolio->experiences()->createMany($validated['experiences']);
            }

            // Simpan Educations jika ada datanya
            if (!empty($validated['educations'])) {
                $portfolio->educations()->createMany($validated['educations']);
            }

            // Simpan Skills jika ada datanya
            if (!empty($validated['skills'])) {
                $portfolio->skills()->createMany($validated['skills']);
            }

            // Simpan Social Links jika ada datanya
            if (!empty($validated['social_links'])) {
                $portfolio->socialLinks()->createMany($validated['social_links']);
            }

            return $portfolio;
        });

        return redirect()->route('dashboard.index')->with('success', 'Portfolio lengkap berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();

        // BENAR: Menyediakan data default jika record baru perlu dibuat
        $portfolio = Portfolio::firstOrCreate(
            ['user_id' => $user->id], // Laravel akan mencari portfolio dengan user_id ini
            [ // Jika tidak ditemukan, Laravel akan MEMBUAT record baru dengan data ini:
                'title' => $user->name . "'s Portfolio", // Pastikan title diisi
                'theme' => 'default',                   // Pastikan theme diisi
                'slug'  => Str::slug($user->name . '-portfolio-' . $user->id) // Pastikan slug diisi
            ]
        );

        $portfolio->load(['projects', 'experiences', 'educations', 'skills', 'socialLinks']);

        return view('dashboard', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // 1. Validasi semua data yang mungkin dikirim dari form
        $validated = $request->validate([
            // Aturan untuk Portfolio
            'title'         => 'required|string|max:150', // Judul harus diisi, berupa teks, maksimal 150 karakter
            'description'   => 'nullable|string',        // Deskripsi boleh kosong, berupa teks
            'theme'         => 'required|string|max:50', // Tema harus diisi, berupa teks, maksimal 50 karakter

            // Aturan untuk Project (sebagai array)
            'projects'      => 'nullable|array',
            'projects.*.title' => 'required_with:projects|string|max:150',
            'projects.*.description' => 'nullable|string',
            'projects.*.technologies' => 'nullable|string',
            'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'projects.*.project_link' => 'nullable|url',
            'projects.*.current_image' => 'nullable|image', // Untuk melacak gambar lama

            // Aturan untuk Experience (sebagai array)
            'experiences'   => 'nullable|array', // Experiences boleh kosong, berupa array
            'experiences.*.company' => 'required_with:experiences|string|max:100', // Nama perusahaan harus diisi jika experiences ada, berupa teks, maksimal 100 karakter
            'experiences.*.position' => 'required_with:experiences|string|max:100', // Posisi harus diisi jika experiences ada, berupa teks, maksimal 100 karakter
            'experiences.*.start_date' => 'required_with:experiences|date', // Tanggal mulai harus diisi jika experiences ada, berupa tanggal
            'experiences.*.end_date' => 'nullable|date|after_or_equal:experiences.*.start_date', // Tanggal selesai boleh kosong, berupa tanggal, dan harus setelah atau sama dengan tanggal mulai
            'experiences.*.description' => 'nullable|string', // Deskripsi pengalaman boleh kosong, berupa teks

            // Aturan untuk Education (sebagai array)
            'educations'    => 'nullable|array', // Educations boleh kosong, berupa array
            'educations.*.institution' => 'required_with:educations|string|max:150', // Nama institusi harus diisi jika educations ada, berupa teks, maksimal 150 karakter
            'educations.*.degree' => 'required_with:educations|string|max:100', // Gelar harus diisi jika educations ada, berupa teks, maksimal 100 karakter
            'educations.*.start_year' => 'required_with:educations|digits:4', // Tahun mulai harus diisi jika educations ada, berupa 4 digit angka
            'educations.*.end_year' => 'nullable|digits:4|gte:educations.*.start_year', // Tahun selesai boleh kosong, berupa 4 digit angka, dan harus lebih besar atau sama dengan tahun mulai
            'educations.*.description' => 'nullable|string', // Deskripsi pendidikan boleh kosong, berupa teks

            // Aturan untuk Skill (sebagai array)
            'skills'        => 'nullable|array', // Skills boleh kosong, berupa array
            'skills.*.skill_name' => 'required_with:skills|string|max:100', // Nama skill harus diisi jika skills ada, berupa teks, maksimal 100 karakter
            'skills.*.level' => 'required_with:skills|in:Beginner,Intermediate,Expert', // Level skill harus diisi jika skills ada, dan harus salah satu dari: Beginner, Intermediate, Expert

            // Aturan untuk Social Link (sebagai array)
            'social_links'  => 'nullable|array', // Social Links boleh kosong, berupa array
            'social_links.*.platform' => 'required_with:social_links|string|max:50', // Platform harus diisi jika social_links ada, berupa teks, maksimal 50 karakter
            'social_links.*.url' => 'required_with:social_links|url', // URL harus diisi jika social_links ada, harus berupa URL yang valid
        ]);

        $imagesToDelete = collect(); // Koleksi untuk menyimpan gambar yang akan dihapus
        // $validated = $request->all();

        // 2. Bungkus semua operasi dalam satu transaksi database
        DB::transaction(function () use ($request, $validated, &$imagesToDelete) {
            $user = Auth::user();
            $portfolio = $user->portfolio;

            // 1. Update data utama dari $validated
            $portfolioData = [
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'theme'       => $validated['theme'],
                'slug'        => Str::slug($validated['title']) . '-' . $user->id,
            ];

            if ($request->hasFile('profile_image')) {
                if ($portfolio->profile_image_path) {
                    // Kumpulkan path gambar untuk dihapus nanti, JANGAN langsung hapus
                    $imagesToDelete->push($portfolio->profile_image_path);
                }
                $portfolioData['profile_image_path'] = $request->file('profile_image')->store('profile_images', 'public');
            }
            $portfolio->update($portfolioData);

            // 2. Sinkronisasi relasi HANYA menggunakan data dari $validated

            // --- Projects (dengan penanganan file yang aman) ---
            $oldProjectImages = $portfolio->projects->pluck('image')->filter();
            $portfolio->projects()->delete();
            $newProjectImages = collect();

            if (!empty($validated['projects'])) {
                foreach ($validated['projects'] as $index => $projectData) {
                    if ($request->hasFile("projects.{$index}.image")) {
                        $projectData['image'] = $request->file("projects.{$index}.image")->store('project_images', 'public');
                    }
                    $createdProject = $portfolio->projects()->create($projectData);
                    if ($createdProject->image) $newProjectImages->push($createdProject->image);
                }
            }
            // Hapus file gambar lama yang tidak terpakai
            $imagesToDelete = $imagesToDelete->merge($oldProjectImages->diff($newProjectImages));

            // --- Sinkronisasi relasi lain (tanpa file) ---
            $portfolio->experiences()->delete();
            // GUNAKAN INI:
            if (!empty($validated['experiences'])) {
                $portfolio->experiences()->createMany($validated['experiences']);
            }

            $portfolio->educations()->delete();
            // GUNAKAN INI:
            if (!empty($validated['educations'])) {
                $portfolio->educations()->createMany($validated['educations']);
            }

            // Lakukan hal yang sama untuk skills dan socialLinks
            $portfolio->skills()->delete();
            if (!empty($validated['skills'])) {
                $portfolio->skills()->createMany($validated['skills']);
            }

            $portfolio->socialLinks()->delete();
            if (!empty($validated['social_links'])) {
                $portfolio->socialLinks()->createMany($validated['social_links']);
            }
        });
        
        if ($imagesToDelete->isNotEmpty()) {
            Storage::disk('public')->delete($imagesToDelete->unique()->all());
        }

        return redirect()->route('dashboard')->with('success', 'Portfolio berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
