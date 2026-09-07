<x-filament-panels::page>
    <form wire:submit="saveVisibility">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit">
                Guardar visibilidad
            </x-filament::button>
        </div>
    </form>

    {{ $this->table }}
</x-filament-panels::page>
