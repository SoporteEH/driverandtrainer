<div>
    <form wire:submit.prevent="save" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
            {{ $isEdit ? 'Editar Trabajo' : 'Registrar Nuevo Trabajo' }}
        </h3>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Evento / Artista -->
            <div>
                <label for="event_artist" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Evento/Artista</label>
                <input type="text" wire:model="event_artist" id="event_artist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('event_artist') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Lugar -->
            <div>
                <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lugar/Ciudad</label>
                <input type="text" wire:model="location" id="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('location') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Furgoneta -->
            <div>
                <label for="van" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Furgoneta</label>
                <input type="text" wire:model="van" id="van" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('van') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Fecha -->
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                <input type="date" wire:model="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Hora Entrada -->
            <div>
                <label for="entry_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora Entrada</label>
                <input type="time" wire:model="entry_time" id="entry_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('entry_time') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Hora Salida -->
            <div>
                <label for="exit_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora Salida</label>
                <input type="time" wire:model="exit_time" id="exit_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                @error('exit_time') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

        </div>

        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        
        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Gastos</h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gasoil -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="expense_fuel">Gasoil</label>
                <input wire:model="expense_fuel" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="expense_fuel" type="file" accept="image/*,application/pdf" capture="environment">
                @error('expense_fuel.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                <div wire:loading wire:target="expense_fuel" class="text-sm text-blue-500 mt-1">Subiendo...</div>
            </div>

            <!-- Comida -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="expense_food">Comida</label>
                <input wire:model="expense_food" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="expense_food" type="file" accept="image/*,application/pdf" capture="environment">
                @error('expense_food.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                <div wire:loading wire:target="expense_food" class="text-sm text-blue-500 mt-1">Subiendo...</div>
            </div>

            <!-- Promotora -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="expense_promoter">Promotora</label>
                <input wire:model="expense_promoter" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="expense_promoter" type="file" accept="image/*,application/pdf" capture="environment">
                @error('expense_promoter.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                <div wire:loading wire:target="expense_promoter" class="text-sm text-blue-500 mt-1">Subiendo...</div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a href="{{ route('dashboard') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Cancelar
            </a>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                {{ $isEdit ? 'Guardar Cambios' : 'Crear Trabajo' }}
            </button>
        </div>

    </form>
</div>
