<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class JobsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $fromDate = '';
    public $toDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'fromDate' => ['except' => ''],
        'toDate' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFromDate()
    {
        $this->resetPage();
    }

    public function updatingToDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = auth()->user()->transportJobs()
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('event_artist', 'like', '%' . $this->search . '%')
                       ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->fromDate, function ($q) {
                $q->where('date', '>=', $this->fromDate);
            })
            ->when($this->toDate, function ($q) {
                $q->where('date', '<=', $this->toDate);
            })
            ->orderBy('date', 'desc');

        return view('livewire.jobs-table', [
            'jobs' => $query->paginate(25)
        ]);
    }
}
