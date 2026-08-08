{{-- Custom Blade View rendering Requirement C: Vehicle Gate Out Screen --}}
<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament::button 
                type="submit" 
                color="danger" 
                icon="heroicon-o-arrow-right-on-rectangle"
                size="lg"
            >
                Confirm & Log Vehicle Exit
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>