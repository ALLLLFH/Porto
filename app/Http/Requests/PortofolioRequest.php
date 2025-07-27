<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set ke true agar semua user yang terotentikasi bisa melakukan request
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Letakkan semua aturan validasi Anda di sini
        return [
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'theme'       => 'required|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'projects'                  => 'nullable|array',
            'projects.*.id'             => 'nullable|exists:projects,id', // Penting untuk update
            'projects.*.title'          => 'required_with:projects|string|max:150',
            'projects.*.description'    => 'nullable|string',
            'projects.*.technologies'   => 'required_with:projects|string',
            'projects.*.image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'projects.*.project_link'   => 'nullable|url',

            // ... tambahkan aturan validasi lainnya untuk experiences, educations, etc.
            'experiences'               => 'nullable|array',
            'experiences.*.id'          => 'nullable|exists:experiences,id',
            'experiences.*.company'     => 'required_with:experiences|string|max:100',
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
            'social_links.*.url' => 'required_with:social_links|url',
        ];
    }
}