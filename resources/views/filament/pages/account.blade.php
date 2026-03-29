<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-3">
                <x-heroicon-o-cog-6-tooth class="w-6 h-6" />
                <span>Informasi Akun</span>
            </div>
        </x-slot>

        <x-slot name="description">
            Kelola informasi akun dan kata sandi Anda
        </x-slot>

        <form wire:submit="save" class="space-y-6">
            {{ $this->form }}

            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <x-filament::button type="submit" color="primary">
                    <x-slot name="icon">
                        <x-heroicon-m-check-circle class="w-4 h-4" />
                    </x-slot>
                    Simpan Perubahan
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
