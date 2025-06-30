<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Menampilkan satu halaman portofolio berdasarkan slug-nya.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // 1. Cari portfolio di database menggunakan slug yang unik
        // firstOrFail() akan otomatis menampilkan halaman 404 Not Found jika slug tidak ada
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();

        // 2. Load semua data relasi yang dibutuhkan untuk ditampilkan
        $portfolio->load(['user', 'projects', 'experiences', 'educations', 'skills', 'socialLinks']);

        // 3. Kirim data portfolio yang lengkap ke view untuk ditampilkan
        return view('portfolio.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
