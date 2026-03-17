<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Recuperar Contraseña
    </h1>
    <p class="font-light text-gray-500 dark:text-gray-400">
        Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </p>

    @if (session()->has('status'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">¡Enviado!</span> {{ session('status') }}
        </div>
    @endif

    <form wire:submit="sendResetLink" class="space-y-4 md:space-y-6 mt-4">
        <div>
            <input type="email" wire:model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') border-red-500 @enderror" placeholder="nombre@empresa.com" required>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:loading.attr="disabled">
            <span wire:loading.remove>Enviar enlace de recuperación</span>
            <span wire:loading>Enviando...</span>
        </button>
        
        <div class="text-sm font-light text-gray-500 dark:text-gray-400">
            ¿Recordaste tu contraseña? <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Inicia sesión</a>
        </div>
    </form>
</div>
