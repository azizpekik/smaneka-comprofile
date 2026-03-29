<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        @php
            $textSettings = \App\Models\Setting::whereNotIn('type', ['image'])->get();
            $imageSettings = \App\Models\Setting::where('type', 'image')->get();
        @endphp

        {{-- Hero Section Settings --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-megaphone class="w-5 h-5" />
                    Hero Section (Banner Utama)
                </div>
            </x-slot>
            <x-slot name="description">
                Bagian banner utama di halaman depan dengan judul besar, subtitle, dan tombol CTA
            </x-slot>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                <div class="flex gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-blue-700 dark:text-blue-300">
                        <p class="font-semibold mb-1">Lokasi di Frontpage:</p>
                        <p>Bagian paling atas halaman depan (banner utama dengan background foto)</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach($textSettings->filter(fn($s) => str_starts_with($s->key, 'hero_') || str_starts_with($s->key, 'stat_')) as $setting)
                    <div>
                        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                            </span>
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea
                                wire:model="settings.{{ $setting->key }}"
                                rows="3"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                        @elseif($setting->type === 'email')
                            <input
                                type="email"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @elseif($setting->type === 'url')
                            <input
                                type="url"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @else
                            <input
                                type="text"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Feature Cards Settings --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-squares-plus class="w-5 h-5" />
                    Feature Cards (3 Kartu Fitur)
                </div>
            </x-slot>
            <x-slot name="description">
                Tiga kartu fitur yang menampilkan keunggulan sekolah
            </x-slot>

            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                <div class="flex gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-green-700 dark:text-green-300">
                        <p class="font-semibold mb-1">Lokasi di Frontpage:</p>
                        <p>Di bawah banner hero, 3 kartu dengan icon (Kurikulum, Fasilitas, Guru)</p>
                        <p class="mt-1 font-semibold">Link: Semua mengarah ke <code class="bg-green-100 dark:bg-green-800 px-2 py-0.5 rounded">/galeri</code></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach($textSettings->filter(fn($s) => str_starts_with($s->key, 'feature_')) as $setting)
                    <div>
                        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                            </span>
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea
                                wire:model="settings.{{ $setting->key }}"
                                rows="3"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                        @else
                            <input
                                type="text"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Who We Are Settings --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-users class="w-5 h-5" />
                    Who We Are Section (Tentang Kami)
                </div>
            </x-slot>
            <x-slot name="description">
                Bagian profil sekolah dengan visi, misi, dan foto kepala sekolah
            </x-slot>

            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 mb-4">
                <div class="flex gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-purple-700 dark:text-purple-300">
                        <p class="font-semibold mb-1">Lokasi di Frontpage:</p>
                        <p>Section "About" dengan foto di kiri dan teks visi-misi di kanan</p>
                        <p class="mt-1 font-semibold">Gambar: Diatur di section "Pengaturan Gambar" bawah (Who We Are Image)</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach($textSettings->filter(fn($s) => str_starts_with($s->key, 'who_we_are_')) as $setting)
                    <div>
                        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                            </span>
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea
                                wire:model="settings.{{ $setting->key }}"
                                rows="4"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                        @else
                            <input
                                type="text"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- General & Contact Settings --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                    General & Contact Settings
                </div>
            </x-slot>
            <x-slot name="description">
                Pengaturan umum situs dan informasi kontak
            </x-slot>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach($textSettings->filter(fn($s) =>
                    in_array($s->key, ['site_name', 'site_tagline', 'contact_address', 'contact_phone', 'contact_whatsapp', 'contact_email', 'website']) ||
                    str_starts_with($s->key, 'social_')
                ) as $setting)
                    <div>
                        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                            </span>
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea
                                wire:model="settings.{{ $setting->key }}"
                                rows="3"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                        @elseif($setting->type === 'email')
                            <input
                                type="email"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @elseif($setting->type === 'url')
                            <input
                                type="url"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @else
                            <input
                                type="text"
                                wire:model="settings.{{ $setting->key }}"
                                value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                class="fi-input block w-full rounded-lg border-gray-200 bg-white shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:border-white/10 dark:bg-white/5 dark:text-white"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Image Settings Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-photo class="w-5 h-5" />
                    Pengaturan Gambar
                </div>
            </x-slot>
            <x-slot name="description">
                Pengaturan untuk gambar dan logo
            </x-slot>

            <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-orange-700 dark:text-orange-300">
                        <p class="font-semibold mb-1">Lokasi Gambar di Frontpage:</p>
                        <ul class="list-disc list-inside space-y-1 mt-1">
                            <li><strong>Logo:</strong> Header (pojok kiri atas) & Footer</li>
                            <li><strong>Header Image:</strong> Banner hero (foto kanan di halaman depan)</li>
                            <li><strong>Who We Are Image:</strong> Section About (foto kepala sekolah di kiri)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($imageSettings as $setting)
                    <div class="rounded-xl p-5 {{ in_array($setting->key, ['logo', 'header_image', 'who_we_are_image', 'favicon']) ? 'bg-white dark:bg-gray-800' : 'border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 hover:border-primary-500 dark:hover:border-primary-400 transition-colors duration-200' }}">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <label class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Upload gambar untuk {{ strtolower(str_replace('_', ' ', $setting->key)) }}
                                </p>
                            </div>
                            @if($setting->value)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <x-heroicon-o-check-circle class="w-4 h-4 mr-1" />
                                    Ada Gambar
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    <x-heroicon-o-no-symbol class="w-4 h-4 mr-1" />
                                    Belum Ada
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-6">
                            @if($setting->value)
                                <div class="relative group flex-shrink-0">
                                    <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="h-24 w-32 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-primary-500 transition-all duration-200">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-lg transition-all duration-200"></div>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <input
                                    type="file"
                                    wire:model="settings.{{ $setting->key }}"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                           file:mr-4 file:py-2.5 file:px-4
                                           file:rounded-lg file:border-0
                                           file:text-sm file:font-semibold
                                           file:bg-primary-50 file:text-primary-700
                                           dark:file:bg-primary-900/30 dark:file:text-primary-300
                                           hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50
                                           transition-colors duration-200
                                           cursor-pointer"
                                />
                                
                                @error('settings.' . $setting->key)
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center gap-1">
                                        <x-heroicon-o-exclamation-circle class="w-4 h-4" />
                                        {{ $message }}
                                    </p>
                                @enderror
                                
                                @if($setting->value)
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        <x-heroicon-o-information-circle class="w-3.5 h-3.5 inline mr-1" />
                                        Upload gambar baru untuk mengganti yang lama
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Save Button --}}
        <div class="fi-ac">
            <x-filament::button type="submit" color="primary" wire:loading.attr="disabled">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
