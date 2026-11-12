@extends('layouts.master')

@section('title', 'Llistat de Productes - JSON')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Productes (JSON)
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('register.form') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Afegir Producte
            </a>
        </div>
    </div>

    @if(empty($productes))
        <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-slate-300">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Encara no hi ha cap producte registrat</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto mb-6">
                No s'han trobat registres. Pots començar afegint-ne un des del formulari.
            </p>
            <a href="{{ route('register.form') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition">
                Anar al Formulari de Registre
            </a>
        </div>
    @else
        <div class="flex items-center justify-between text-xs text-slate-500 px-1">
            <span>Total de registres: <strong class="text-slate-800">{{ count($productes) }}</strong></span>
        </div>

        <div class="relative overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs font-semibold uppercase bg-slate-100 text-slate-700 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Nom del Producte</th>
                        <th scope="col" class="px-6 py-4">Descripció</th>
                        <th scope="col" class="px-6 py-4 text-right">Preu Base</th>
                        <th scope="col" class="px-6 py-4 text-center">IVA</th>
                        <th scope="col" class="px-6 py-4 text-right text-indigo-700">Preu amb IVA</th>
                        <th scope="col" class="px-6 py-4 text-center">Color</th>
                        <th scope="col" class="px-6 py-4 text-center">Talla</th>
                        <th scope="col" class="px-6 py-4 text-right">Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($productes as $index => $prod)
                        <tr class="hover:bg-amber-50/40 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-500 whitespace-nowrap">
                                #{{ $prod->id }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                {{ $prod->nom }}
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-slate-600" title="{{ $prod->descripcio }}">
                                {{ $prod->descripcio }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-slate-800 whitespace-nowrap">
                                {{ $prod->getPreuFormatejat() }} €
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $prod->getIvaFormatejat() }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap font-extrabold text-indigo-700">
                                {{ $prod->getPreuIvaFormatejat() }} €
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $prod->color }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $prod->talla }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-slate-400 whitespace-nowrap font-mono">
                                {{ $prod->data_registre }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
