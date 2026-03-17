<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function destroy(Expense $expense)
    {
        if (auth()->id() !== $expense->transportJob->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }
        if (!$expense->transportJob->isEditable() && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'No se puede eliminar un archivo de un trabajo con más de 10 días.');
        }

        if ($expense->file_path) {
            Storage::delete($expense->file_path);
        }
        $expense->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }
}
