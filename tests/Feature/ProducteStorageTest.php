<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProducteStorageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
    }

    public function test_la_pagina_principal_carrega_correctament(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Gestió de Productes');
    }

    public function test_el_formulari_de_registre_carrega_correctament(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Registrar Producte');
        $response->assertSee('value="21"', false);
    }

    public function test_registre_de_producte_calcula_iva_i_desa_en_json_i_xml(): void
    {
        $dadesProducte = [
            'nom' => 'Samarreta Esportiva Herd',
            'descripcio' => 'Teixit transpirable i d\'assecat ràpid',
            'preu' => '20.00',
            'iva' => '21',
            'color' => 'Blau marí',
            'talla' => 'M',
        ];

        $response = $this->post('/register', $dadesProducte);

        $response->assertRedirect('/register');
        $response->assertSessionHas('success');

        Storage::disk('local')->assertExists('productes.json');
        $jsonContingut = Storage::disk('local')->get('productes.json');
        $productesJson = json_decode($jsonContingut, true);

        $this->assertIsArray($productesJson);
        $this->assertCount(1, $productesJson);
        $this->assertEquals('Samarreta Esportiva Herd', $productesJson[0]['nom']);
        $this->assertEquals('24.20', $productesJson[0]['preu_iva']);

        Storage::disk('public')->assertExists('productes.xml');
        $xmlContingut = Storage::disk('public')->get('productes.xml');
        $xml = simplexml_load_string($xmlContingut);

        $this->assertNotFalse($xml);
        $this->assertEquals('Samarreta Esportiva Herd', (string) $xml->producte[0]->nom);
        $this->assertEquals('24.20', (string) $xml->producte[0]->preu_iva);
        $this->assertEquals('Blau marí', (string) $xml->producte[0]->color);
        $this->assertEquals('M', (string) $xml->producte[0]->talla);
    }

    public function test_afegir_segon_producte_acumula_els_registres_sense_esborrar_anteriors(): void
    {
        $this->post('/register', [
            'nom' => 'Pantaló Curts',
            'descripcio' => 'Pantalons esportius amb butxaques',
            'preu' => '15.00',
            'iva' => '21',
            'color' => 'Negre',
            'talla' => 'L',
        ]);

        $this->post('/register', [
            'nom' => 'Mitjons Running',
            'descripcio' => 'Pack de 3 parells',
            'preu' => '10.00',
            'iva' => '10',
            'color' => 'Blanc',
            'talla' => 'S',
        ]);

        $productesJson = json_decode(Storage::disk('local')->get('productes.json'), true);
        $this->assertCount(2, $productesJson);
        $this->assertEquals('11.00', $productesJson[1]['preu_iva']);

        $xml = simplexml_load_string(Storage::disk('public')->get('productes.xml'));
        $this->assertCount(2, $xml->producte);
    }

    public function test_vistes_tabulars_json_i_xml_mostren_les_dades(): void
    {
        $this->post('/register', [
            'nom' => 'Dessuadora Cotó',
            'descripcio' => 'Dessuadora càlida amb caputxa',
            'preu' => '40.00',
            'iva' => '21',
            'color' => 'Gris',
            'talla' => 'XL',
        ]);

        $responseJson = $this->get('/json');
        $responseJson->assertStatus(200);
        $responseJson->assertSee('Dessuadora Cotó');
        $responseJson->assertSee('48.40');

        $responseXml = $this->get('/xml');
        $responseXml->assertStatus(200);
        $responseXml->assertSee('Dessuadora Cotó');
        $responseXml->assertSee('48.40');
    }
}
