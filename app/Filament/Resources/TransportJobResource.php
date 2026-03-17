<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransportJobResource\Pages;
use App\Models\TransportJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TransportJobResource extends Resource
{
    protected static ?string $model = TransportJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?string $modelLabel = 'Trabajo';
    protected static ?string $pluralModelLabel = 'Trabajos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Empleado')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('event_artist')
                    ->label('Evento/Artista')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->label('Lugar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('van')
                    ->label('Furgoneta')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->required(),
                Forms\Components\TimePicker::make('entry_time')
                    ->label('Hora Entrada')
                    ->required(),
                Forms\Components\TimePicker::make('exit_time')
                    ->label('Hora Salida')
                    ->required(),
                Forms\Components\Repeater::make('expenses')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipo de Gasto')
                            ->options([
                                'fuel' => 'Gasoil',
                                'food' => 'Comida',
                                'promoter' => 'Promotora',
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Justificante')
                            ->directory(function (\Filament\Forms\Components\FileUpload $component) {
                                $livewire = $component->getLivewire();
                                $job = property_exists($livewire, 'record') ? $livewire->record : null;
                                
                                if ($job && $job->exists) {
                                    $date = \Carbon\Carbon::parse($job->date ?? now());
                                    $year = $date->format('Y');
                                    $month = $date->format('m');
                                    return "expenses/{$year}/{$month}/user_{$job->user_id}/job_{$job->id}";
                                }
                                return 'expenses/admin/' . date('Y/m');
                            })
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize(5120)
                            ->required(),
                    ])
                    ->label('Gastos Adjuntos')
                    ->columns(2)
                    ->defaultItems(0)
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Empleado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_artist')
                    ->label('Evento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lugar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('entry_time')
                    ->label('Entrada')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('exit_time')
                    ->label('Salida')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Filtrar por Empleado'),
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('desde'),
                        Forms\Components\DatePicker::make('hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListTransportJobs::route('/'),
            'create' => Pages\CreateTransportJob::route('/create'),
            'edit' => Pages\EditTransportJob::route('/{record}/edit'),
        ];
    }
}
