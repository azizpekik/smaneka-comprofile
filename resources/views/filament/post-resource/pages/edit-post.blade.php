<x-filament-panels::page>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <span id="auto-save-status" class="text-sm text-gray-500">
                @if($this->record->updated_at)
                    Terakhir disimpan: {{ $this->record->updated_at->diffForHumans() }}
                @endif
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg wire:loading wire:target="save" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <x-heroicon-o-cloud-arrow-up wire:loading.remove wire:target="save" class="w-4 h-4" />
                <span wire:loading.remove wire:target="save">Simpan Sekarang</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <script>
        // Auto-save functionality
        document.addEventListener('livewire:init', () => {
            let autoSaveInterval;
            const AUTO_SAVE_DELAY = 30000; // 30 seconds

            // Start auto-save timer
            function startAutoSave() {
                autoSaveInterval = setInterval(() => {
                    const saveButton = document.querySelector('button[wire\\:click="save"]');
                    if (saveButton && !saveButton.disabled) {
                        saveButton.click();
                    }
                }, AUTO_SAVE_DELAY);
            }

            // Stop auto-save timer
            function stopAutoSave() {
                if (autoSaveInterval) {
                    clearInterval(autoSaveInterval);
                }
            }

            // Restart timer on form input change
            document.querySelectorAll('input, textarea, select').forEach(element => {
                element.addEventListener('input', () => {
                    stopAutoSave();
                    startAutoSave();
                    
                    // Update status
                    const statusEl = document.getElementById('auto-save-status');
                    if (statusEl) {
                        statusEl.textContent = 'Mengetik...';
                        statusEl.classList.add('text-secondary-600');
                    }
                });
            });

            // Listen for Livewire save completion
            Livewire.on('saved', () => {
                const statusEl = document.getElementById('auto-save-status');
                if (statusEl) {
                    statusEl.textContent = 'Disimpan otomatis: Baru saja';
                    statusEl.classList.remove('text-secondary-600');
                }
            });

            // Start initial timer
            startAutoSave();

            // Cleanup on page unload
            window.addEventListener('beforeunload', () => {
                stopAutoSave();
            });
        });
    </script>
</x-filament-panels::page>
