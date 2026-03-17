<?php

namespace App\Livewire;

use App\Models\TransportJob;
use App\Models\Expense;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateJobForm extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public TransportJob $job;

    public $event_artist;
    public $location;
    public $van;
    public $date;
    public $entry_time;
    public $exit_time;

    public $expense_fuel = [];
    public $expense_food = [];
    public $expense_promoter = [];

    public $isEdit = false;

    public function mount(TransportJob $job = null)
    {
        if ($job && $job->exists) {
            $this->authorize('update', $job);
            
            $this->job = $job;
            $this->event_artist = $job->event_artist;
            $this->location = $job->location;
            $this->van = $job->van;
            $this->date = $job->date ? $job->date->format('Y-m-d') : '';
            $this->entry_time = \Carbon\Carbon::parse($job->entry_time)->format('H:i');
            $this->exit_time = \Carbon\Carbon::parse($job->exit_time)->format('H:i');
            $this->isEdit = true;
        } else {
            $this->job = new TransportJob();
        }
    }

    protected function rules()
    {
        return [
            'event_artist' => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'van'          => 'required|string|max:255',
            'date'         => 'required|date',
            'entry_time'   => 'required|date_format:H:i',
            'exit_time'    => 'required|date_format:H:i', // Removed after:entry_time to allow midnight shifts

            'expense_fuel'       => 'nullable|array|max:10',
            'expense_fuel.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
            'expense_food'       => 'nullable|array|max:10',
            'expense_food.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
            'expense_promoter'   => 'nullable|array|max:10',
            'expense_promoter.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    protected function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'date_format' => 'El campo :attribute debe coincidir con el formato H:i.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'after' => 'El campo :attribute debe ser una hora posterior a :date.',
            'mimes' => 'El archivo :attribute debe ser de tipo: jpg, jpeg, png o pdf.',
            'max' => [
                'file' => 'El archivo :attribute no debe pesar más de :max kilobytes.',
                'string' => 'El campo :attribute no debe tener más de :max caracteres.',
                'array' => 'No puedes subir más de :max archivos en :attribute.',
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'event_artist' => 'Evento/Artista',
            'location'     => 'Lugar/Ciudad',
            'van'          => 'Furgoneta',
            'date'         => 'Fecha',
            'entry_time'   => 'Hora Entrada',
            'exit_time'    => 'Hora Salida',
            'expense_fuel' => 'Gasoil',
            'expense_food' => 'Comida',
            'expense_promoter' => 'Promotora',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->job->user_id = auth()->id();
        $this->job->event_artist = $this->event_artist;
        $this->job->location = $this->location;
        $this->job->van = $this->van;
        $this->job->date = $this->date;
        $this->job->entry_time = $this->entry_time;
        $this->job->exit_time = $this->exit_time;

        $this->job->save();

        // Process expenses (Support array of files)
        $this->saveExpense('fuel', $this->expense_fuel);
        $this->saveExpense('food', $this->expense_food);
        $this->saveExpense('promoter', $this->expense_promoter);

        session()->flash('success', $this->isEdit ? 'Trabajo actualizado correctamente.' : 'Trabajo registrado correctamente.');

        return redirect()->route('dashboard');
    }

    private function saveExpense($type, $files)
    {
        if (empty($files) || !is_array($files)) {
            return;
        }

        $date = \Carbon\Carbon::parse($this->job->date);
        $year = $date->format('Y');
        $month = $date->format('m');
        $userId = $this->job->user_id;
        $jobId = $this->job->id;

        // Hierarchical structure: expenses/2026/03/user_15/job_1042
        $directory = "expenses/{$year}/{$month}/user_{$userId}/job_{$jobId}";

        foreach ($files as $file) {
            $path = $file->store($directory, 'public');

            // Insert a new record for each uploaded file within this category
            Expense::create([
                'transport_job_id' => $this->job->id,
                'type' => $type,
                'file_path' => $path
            ]);
        }
    }

    public function render()
    {
        return view('livewire.create-job-form');
    }
}
