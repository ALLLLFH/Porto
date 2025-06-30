<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Aturan untuk Project (sebagai array)
        'projects'      => 'nullable|array',
        'projects.*.title' => 'required_with:projects|string|max:150',
        'projects.*.description' => 'nullable|string',
        'projects.*.technologies' => 'nullable|string',
        'projects.*.image' => 'nullable|string|max:255',
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
    $portfolio = DB::transaction(function () use ($validated) {
        $user_id = Auth::id();

        // Buat entitas utama: Portfolio
        $portfolio = Portfolio::create([
            'user_id'     => $user_id,
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'theme'       => $validated['theme'],
            'slug'        => Str::slug($validated['title']) . '-' . $user_id,
        ]);

        // 3. Gunakan pola yang sama untuk menyimpan setiap data relasi
        
        // Simpan Projects jika ada datanya
        if (!empty($validated['projects'])) {
            $portfolio->projects()->createMany($validated['projects']);
        }

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

        // 1. Ambil portfolio milik user, atau buat baru jika belum ada
        $portfolio = Portfolio::firstOrCreate(
            ['user_id' => $user->id]
        );
        
        // 2. Load SEMUA data relasi yang terkait dengan portfolio ini
        $portfolio->load(['projects', 'experiences', 'educations', 'skills', 'socialLinks']);

        // 3. Kirim objek $portfolio yang sudah lengkap dengan semua relasinya ke view
        return view('dashboard', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // 1. Validasi semua data yang mungkin dikirim dari form
        $validated = $request->validate([
            'title'         => 'required|string|max:150',
            'description'   => 'nullable|string',
            'theme'         => 'required|string|max:50',
            'projects'      => 'nullable|array',
            'projects.*.title' => 'required_with:projects|string|max:150',
            'projects.*.description' => 'nullable|string',
            'projects.*.technologies' => 'nullable|string',
            'projects.*.image' => 'nullable|string|max:255',
            'projects.*.project_link' => 'nullable|url',
            'experiences'   => 'nullable|array',
            'experiences.*.company' => 'required_with:experiences|string|max:100',
            'experiences.*.position' => 'required_with:experiences|string|max:100',
            'experiences.*.start_date' => 'required_with:experiences|date',
            'experiences.*.end_date' => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.description' => 'nullable|string',
            'educations'    => 'nullable|array',
            'educations.*.institution' => 'required_with:educations|string|max:150',
            'educations.*.degree' => 'required_with:educations|string|max:100',
            'educations.*.start_year' => 'required_with:educations|digits:4',
            'educations.*.end_year' => 'nullable|digits:4|gte:educations.*.start_year',
            'educations.*.description' => 'nullable|string',
            'skills'        => 'nullable|array',
            'skills.*.skill_name' => 'required_with:skills|string|max:100',
            'skills.*.level' => 'required_with:skills|in:Beginner,Intermediate,Expert',
            'social_links'  => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|max:50',
            'social_links.*.url' => 'required_with:social_links|url',
        ]);

        // 2. Bungkus semua operasi dalam satu transaksi database
        DB::transaction(function () use ($validated) {
            $user = Auth::user();
            $portfolio = $user->portfolio;

            // 3. Update data utama (tabel portfolios)
            $portfolio->update([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'theme'       => $validated['theme'],
                'slug'        => Str::slug($validated['title']) . '-' . $user->id,
            ]);

            // 4. Sinkronkan semua data relasi dengan pola "Hapus dan Buat Ulang"
            
            // --- Projects ---
            $portfolio->projects()->delete();
            if (!empty($validated['projects'])) {
                $portfolio->projects()->createMany($validated['projects']);
            }

            // --- Experiences ---
            $portfolio->experiences()->delete();
            if (!empty($validated['experiences'])) {
                $portfolio->experiences()->createMany($validated['experiences']);
            }

            // --- Educations ---
            $portfolio->educations()->delete();
            if (!empty($validated['educations'])) {
                $portfolio->educations()->createMany($validated['educations']);
            }

            // --- Skills ---
            $portfolio->skills()->delete();
            if (!empty($validated['skills'])) {
                $portfolio->skills()->createMany($validated['skills']);
            }

            // --- Social Links ---
            $portfolio->socialLinks()->delete();
            if (!empty($validated['social_links'])) {
                $portfolio->socialLinks()->createMany($validated['social_links']);
            }
        });

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->route('dashboard.edit')->with('success', 'Portfolio berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
