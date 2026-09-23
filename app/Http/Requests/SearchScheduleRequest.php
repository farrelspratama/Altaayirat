<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchScheduleRequest extends FormRequest
{
    /**
     * Untuk saat ini semua orang boleh mencari jadwal (tidak perlu login),
     * jadi selalu true. Method ini berguna nanti kalau ada aturan otorisasi
     * lebih rumit, misal "hanya user dengan role tertentu yang boleh akses".
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Di sinilah aturan validasi didefinisikan - menggantikan ketiadaan
     * validasi sama sekali di versi lama.
     */
    public function rules(): array
    {
        return [
            'departure_airport_id' => ['required', 'exists:airports,id'],
            'arrival_airport_id' => ['required', 'exists:airports,id', 'different:departure_airport_id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    /**
     * Pesan error custom berbahasa Indonesia, supaya user tidak melihat
     * pesan default bahasa Inggris Laravel.
     */
    public function messages(): array
    {
        return [
            'departure_airport_id.required' => 'Bandara keberangkatan wajib dipilih.',
            'departure_airport_id.exists' => 'Bandara keberangkatan tidak valid.',
            'arrival_airport_id.required' => 'Bandara tujuan wajib dipilih.',
            'arrival_airport_id.exists' => 'Bandara tujuan tidak valid.',
            'arrival_airport_id.different' => 'Bandara tujuan harus berbeda dari keberangkatan.',
            'date.required' => 'Tanggal keberangkatan wajib diisi.',
            'date.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
        ];
    }
}
