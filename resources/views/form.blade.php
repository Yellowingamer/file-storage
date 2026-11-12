@extends('layouts.master')

@section('title', 'Registrar Producte')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 mb-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nou Registre
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
            Registrar Producte
        </h1>
        <p class="text-slate-500 mt-2 text-sm sm:text-base">
            Introdueix les dades per afegir un nou producte al catàleg.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 p-6 sm:p-10">
        <form action="{{ route('register.store') }}" method="POST" class="space-y-6" id="productForm">
            @csrf

            <div>
                <label for="nom" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nom del Producte <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="nom" 
                        id="nom" 
                        required
                        maxlength="100"
                        placeholder="Ex: Samarreta tècnica esportiva" 
                        value="{{ old('nom') }}"
                        class="w-full px-4 py-3 rounded-xl border @error('nom') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2"
                    >
                </div>
                @error('nom')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="descripcio" class="block text-sm font-semibold text-slate-700 mb-2">
                    Descripció <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="descripcio" 
                    id="descripcio" 
                    rows="3" 
                    required
                    maxlength="1000"
                    placeholder="Descriu les característiques, materials i ús recomanat..." 
                    class="w-full px-4 py-3 rounded-xl border @error('descripcio') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 resize-y"
                >{{ old('descripcio') }}</textarea>
                @error('descripcio')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="preu" class="block text-sm font-semibold text-slate-700 mb-2">
                        Preu sense IVA (€) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            name="preu" 
                            id="preu" 
                            step="0.01" 
                            min="0"
                            required
                            placeholder="0.00" 
                            value="{{ old('preu') }}"
                            class="w-full pl-4 pr-9 py-3 rounded-xl border @error('preu') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 font-semibold text-sm">
                            €
                        </div>
                    </div>
                    @error('preu')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="iva" class="block text-sm font-semibold text-slate-700 mb-2">
                        IVA (%) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            name="iva" 
                            id="iva" 
                            step="0.1" 
                            min="0"
                            max="100"
                            required
                            placeholder="21" 
                            value="{{ old('iva', '21') }}"
                            class="w-full pl-4 pr-9 py-3 rounded-xl border @error('iva') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 font-semibold text-sm">
                            %
                        </div>
                    </div>
                    @error('iva')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shadow-sm">
                        €
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-indigo-900 uppercase tracking-wider">Preu amb IVA</div>
                    </div>
                </div>
                <div class="text-right">
                    <span id="previewPreuAmbIva" class="text-xl sm:text-2xl font-black text-indigo-900">0.00 €</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="color" class="block text-sm font-semibold text-slate-700 mb-2">
                        Color <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="color" 
                        id="color" 
                        required
                        placeholder="Ex: Blau marí, Negre" 
                        value="{{ old('color') }}"
                        class="w-full px-4 py-3 rounded-xl border @error('color') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2"
                    >
                    @error('color')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="talla" class="block text-sm font-semibold text-slate-700 mb-2">
                        Talla <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="talla" 
                        id="talla" 
                        required
                        class="w-full px-4 py-3 rounded-xl border @error('talla') border-rose-300 bg-rose-50/50 text-rose-900 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror shadow-sm transition duration-150 text-slate-800 focus:outline-none focus:ring-2 bg-white"
                    >
                        <option value="" disabled {{ old('talla') ? '' : 'selected' }}>Selecciona una talla...</option>
                        <option value="XS" {{ old('talla') == 'XS' ? 'selected' : '' }}>XS</option>
                        <option value="S" {{ old('talla') == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ old('talla') == 'M' ? 'selected' : '' }}>M</option>
                        <option value="L" {{ old('talla') == 'L' ? 'selected' : '' }}>L</option>
                        <option value="XL" {{ old('talla') == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ old('talla') == 'XXL' ? 'selected' : '' }}>XXL</option>
                        <option value="Única" {{ old('talla') == 'Única' ? 'selected' : '' }}>Talla Única</option>
                    </select>
                    @error('talla')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                <button 
                    type="submit" 
                    class="flex-1 py-3.5 px-6 text-white font-semibold bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-md transition duration-200 flex items-center justify-center gap-2 cursor-pointer text-base"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Guardar Producte</span>
                </button>
                <a 
                    href="{{ route('home') }}" 
                    class="py-3.5 px-6 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium transition duration-200 text-center"
                >
                    Cancel·lar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const preuInput = document.getElementById('preu');
    const ivaInput = document.getElementById('iva');
    const previewPreuAmbIva = document.getElementById('previewPreuAmbIva');

    function updatePricePreview() {
        const preu = parseFloat(preuInput.value) || 0;
        const iva = parseFloat(ivaInput.value) || 0;
        const total = preu * (1 + (iva / 100));
        previewPreuAmbIva.textContent = total.toFixed(2) + ' €';
    }

    preuInput.addEventListener('input', updatePricePreview);
    ivaInput.addEventListener('input', updatePricePreview);
    updatePricePreview();
</script>
@endpush
