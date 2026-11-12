<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producte;

class ProducteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showForm()
    {
        return view('form');
    }

    public function registerProduct(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'descripcio' => 'required|string|max:1000',
            'preu' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0|max:100',
            'color' => 'required|string|max:50',
            'talla' => 'required|string|max:20',
        ]);

        $producte = new Producte(
            nom: $validated['nom'],
            descripcio: $validated['descripcio'],
            preu: (float) $validated['preu'],
            iva: (float) $validated['iva'],
            color: $validated['color'],
            talla: $validated['talla'],
        );

        $producte->guardarEnJson();
        $producte->guardarEnXml();

        return redirect()->route('register.form')->with('success', 'Producte registrat correctament en JSON i XML!');
    }

    public function showXml()
    {
        $productes = Producte::obtenirDeXml();

        return view('xml', [
            'productes' => $productes,
            'rutaFitxer' => 'storage/app/public/' . Producte::FITXER_XML,
        ]);
    }

    public function showJson()
    {
        $productes = Producte::obtenirDeJson();

        return view('json', [
            'productes' => $productes,
            'rutaFitxer' => 'storage/app/' . Producte::FITXER_JSON,
        ]);
    }
}
