<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageExpenses extends ManageRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): \Illuminate\Database\Eloquent\Model {
                    $bulkExpenses = $data['bulk_expenses'] ?? [];
                    $transportJobId = $data['transport_job_id'];
                    $lastCreated = null;

                    foreach ($bulkExpenses as $group) {
                        $type = $group['type'];
                        $paths = $group['paths'] ?? [];

                        foreach ($paths as $path) {
                            $lastCreated = $model::create([
                                'transport_job_id' => $transportJobId,
                                'type' => $type,
                                'file_path' => $path,
                            ]);
                        }
                    }

                    // Return the last created record (or a fresh instance if none created)
                    return $lastCreated ?? $model::make($data);
                }),
        ];
    }
}
