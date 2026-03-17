@props([
    'id' => 'delete-modal',
    'title' => 'Confirmar eliminación',
    'message' => '¿Estás seguro? Esta acción no se puede deshacer.'
])

<dialog id="{{ $id }}"
        style="border:none; border-radius:1rem; padding:0; background:transparent; max-width:24rem; width:100%; margin:auto;">
    <style>
        #{{ $id }}::backdrop { background: rgba(0,0,0,.65); backdrop-filter: blur(4px); }
    </style>
    <div style="background:#1f2937; border-radius:1rem; padding:1.75rem; text-align:center; box-shadow:0 25px 60px rgba(0,0,0,.6);">
        <div style="margin:0 auto .75rem; display:flex; align-items:center; justify-content:center; width:3.5rem; height:3.5rem; border-radius:50%; background:rgba(153,27,27,.25);">
            <svg style="width:1.6rem;height:1.6rem;" fill="none" stroke="#f87171" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 style="font-size:1.1rem;font-weight:700;color:#f9fafb;margin:0 0 .35rem;">{{ $title }}</h3>
        <p style="font-size:.875rem;color:#9ca3af;margin:0 0 1.5rem;">{{ $message }}</p>
        <div style="display:flex;gap:.75rem;">
            <button type="button" onclick="document.getElementById('{{ $id }}').close()"
                    style="flex:1;padding:.6rem 1rem;border-radius:.75rem;font-size:.875rem;font-weight:600;background:#374151;color:#d1d5db;border:none;cursor:pointer;">
                Cancelar
            </button>
            <button type="button" onclick="window['submit_{{ $id }}']()"
                    style="flex:1;padding:.6rem 1rem;border-radius:.75rem;font-size:.875rem;font-weight:600;background:#dc2626;color:#fff;border:none;cursor:pointer;">
                Sí, eliminar
            </button>
        </div>
    </div>
</dialog>

<script>
    (function() {
        var _targetFormId = null;
        var dialog = document.getElementById('{{ $id }}');

        window['open_{{ $id }}'] = function(formId) {
            _targetFormId = formId;
            dialog.showModal();
        };

        window['submit_{{ $id }}'] = function() {
            if (_targetFormId) {
                document.getElementById(_targetFormId).submit();
            }
        };
    })();
</script>
