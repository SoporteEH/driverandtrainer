<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_artist' => ['required', 'string', 'max:255'],
            'location'     => ['required', 'string', 'max:255'],
            'van'          => ['required', 'string', 'max:255'],
            'date'         => ['required', 'date'],
            'entry_time'   => ['required', 'date_format:H:i'],
            'exit_time'    => ['required', 'date_format:H:i', 'after:entry_time'],
            
            // Expenses files (arrays for multiple upload)
            'expense_fuel'       => ['nullable', 'array', 'max:10'], // Max 10 files per category
            'expense_fuel.*'     => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'expense_food'       => ['nullable', 'array', 'max:10'],
            'expense_food.*'     => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'expense_promoter'   => ['nullable', 'array', 'max:10'],
            'expense_promoter.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'event_artist' => 'Evento / Artista',
            'location'     => 'Lugar',
            'van'          => 'Furgoneta',
            'date'         => 'Fecha',
            'entry_time'   => 'Hora de entrada',
            'exit_time'    => 'Hora de salida',
            'expense_fuel' => 'Gastos de gasoil',
            'expense_fuel.*' => 'Archivo de gasto de gasoil',
            'expense_food' => 'Gastos de comida',
            'expense_food.*' => 'Archivo de gasto de comida',
            'expense_promoter' => 'Gastos de promotora',
            'expense_promoter.*' => 'Archivo de gasto de promotora',
        ];
    }
}
