<?php

namespace App\Http\Controllers;

use App\Models\TransportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransportJobController extends Controller
{
    public function index()
    {
        return view('jobs.index');
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(TransportJob $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(TransportJob $job)
    {
        if (auth()->id() !== $job->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if (!$job->isEditable() && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'No se puede editar un trabajo con más de 10 días.');
        }

        return view('jobs.edit', compact('job'));
    }

    public function destroy(TransportJob $job)
    {
        if (auth()->id() !== $job->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if (!$job->isEditable() && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'No se puede eliminar un trabajo con más de 10 días.');
        }

        // Delete associated expenses files
        foreach ($job->expenses as $expense) {
            if ($expense->file_path) {
                \Illuminate\Support\Facades\Storage::delete($expense->file_path);
            }
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Trabajo eliminado correctamente.');
    }
}
