<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-euro';
    
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?string $modelLabel = 'Gasto';
    protected static ?string $pluralModelLabel = 'Gastos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transport_job_id')
                    ->relationship('transportJob', 'event_artist')
                    ->label('Trabajo Relacionado')
                    ->required()
                    ->searchable()
                    ->columnSpanFull(),

                // Bulk creation section (only visible on create)
                Forms\Components\Repeater::make('bulk_expenses')
                    ->label('Adjuntar gastos por Categoría')
                    ->visibleOn('create')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Tipo de Gasto')
                                    ->options([
                                        'fuel' => 'Gasoil',
                                        'food' => 'Comida',
                                        'promoter' => 'Promotora',
                                    ])
                                    ->required(),
                                Forms\Components\FileUpload::make('paths')
                                    ->label('Seleccionar Archivos')
                                    ->multiple()
                                    ->directory(function (Forms\Components\FileUpload $component, Forms\Get $get) {
                                        $jobId = $get('../../transport_job_id');
                                        if (!$jobId) return 'expenses/temp';
                                        
                                        $job = \App\Models\TransportJob::find($jobId);
                                        if (!$job) return 'expenses/temp';

                                        $date = \Carbon\Carbon::parse($job->date ?? now());
                                        $year = $date->format('Y');
                                        $month = $date->format('m');
                                        
                                        return "expenses/{$year}/{$month}/user_{$job->user_id}/job_{$job->id}";
                                    })
                                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                    ->maxSize(5120)
                                    ->required(),
                            ]),
                    ])
                    ->dehydrated(false)
                    ->columnSpanFull()
                    ->addActionLabel('Añadir otra categoría'),

                // Edit section (only visible on edit)
                Forms\Components\Select::make('type')
                    ->label('Tipo de Gasto')
                    ->options([
                        'fuel' => 'Gasoil',
                        'food' => 'Comida',
                        'promoter' => 'Promotora',
                    ])
                    ->required()
                    ->visibleOn('edit'),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Justificante')
                    ->directory(function (Forms\Components\FileUpload $component, Forms\Get $get) {
                        $jobId = $get('transport_job_id');
                        if (!$jobId) {
                            // If we are editing, we can get it from the record
                            $record = $component->getRecord();
                            $jobId = $record?->transport_job_id;
                        }
                        
                        if (!$jobId) return 'expenses/admin/' . date('Y/m');
                        
                        $job = \App\Models\TransportJob::find($jobId);
                        if (!$job) return 'expenses/admin/' . date('Y/m');

                        $date = \Carbon\Carbon::parse($job->date ?? now());
                        $year = $date->format('Y');
                        $month = $date->format('m');
                        
                        return "expenses/{$year}/{$month}/user_{$job->user_id}/job_{$job->id}";
                    })
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(5120)
                    ->required()
                    ->visibleOn('edit'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['transportJob.user']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transportJob.user.name')
                    ->label('Empleado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transportJob.event_artist')
                    ->label('Trabajo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'fuel' => 'Gasoil',
                        'food' => 'Comida',
                        'promoter' => 'Promotora',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'fuel',
                        'success' => 'food',
                        'danger' => 'promoter',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Subida')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Filtrar por Tipo')
                    ->options([
                        'fuel' => 'Gasoil',
                        'food' => 'Comida',
                        'promoter' => 'Promotora',
                    ]),
                SelectFilter::make('user_id')
                    ->label('Filtrar por Empleado')
                    ->relationship('transportJob.user', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('descargar')
                    ->label('Ver / Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Expense $record) => Storage::url($record->file_path))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageExpenses::route('/'),
        ];
    }
}
