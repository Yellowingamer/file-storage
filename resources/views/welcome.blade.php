@extends('layouts.master')

@section('title', 'Inici')

@section('content')
<div class="space-y-10">
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-2xl">
        <div class="relative z-10 max-w-3xl space-y-4">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Gestió de Productes <br>
                <span class="bg-gradient-to-r from-indigo-200 via-violet-200 to-pink-200 bg-clip-text text-transparent">JSON & XML</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
                Aplicació per gestionar el registre de productes amb càlcul automàtic de l'IVA i consulta de dades en formats JSON i XML.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Formulari de Registre</h3>
            <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                Permet introduir nous productes amb nom, descripció, preu, IVA, color i talla, aplicant el càlcul automàtic del preu de venda.
            </p>
            <a href="{{ route('register.form') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                Obrir formulari &rarr;
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Llistat JSON</h3>
            <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                Consulta la taula amb tots els productes registrats guardats en format JSON.
            </p>
            <a href="{{ route('json.show') }}" class="inline-flex items-center text-sm font-semibold text-amber-600 hover:text-amber-800">
                Consultar taula JSON &rarr;
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Llistat XML</h3>
            <p class="text-slate-600 text-sm mb-4 leading-relaxed">
                Consulta la taula amb tots els productes registrats guardats en format XML.
            </p>
            <a href="{{ route('xml.show') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800">
                Consultar taula XML &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
