<?php

namespace Tests\Unit;

use App\Models\Producte;
use PHPUnit\Framework\TestCase;

class ProducteTest extends TestCase
{
    public function test_creacio_objecte_producte_calcula_iva_automaticament(): void
    {
        $producte = new Producte(
            nom: 'Pantaló Texà',
            descripcio: 'Teixit texà d\'alta resistència',
            preu: 50.00,
            iva: 21.0,
            color: 'Blau marí',
            talla: 'M'
        );

        $this->assertInstanceOf(Producte::class, $producte);
        $this->assertEquals('Pantaló Texà', $producte->nom);
        $this->assertEquals(60.50, $producte->preu_iva);
        $this->assertEquals('50.00', $producte->getPreuFormatejat());
        $this->assertEquals('60.50', $producte->getPreuIvaFormatejat());
    }

    public function test_instanciacio_des_de_array(): void
    {
        $dades = [
            'nom' => 'Jaqueta Polar',
            'descripcio' => 'Ideal per a l\'hivern',
            'preu' => 30.00,
            'iva' => 10.0,
            'preu_iva' => 33.00,
            'color' => 'Gris',
            'talla' => 'XL',
            'data_registre' => '2026-10-28 12:00:00',
        ];

        $producte = Producte::fromArray($dades);

        $this->assertEquals('Jaqueta Polar', $producte->nom);
        $this->assertEquals(33.00, $producte->preu_iva);
        $this->assertEquals('2026-10-28 12:00:00', $producte->data_registre);
    }

    public function test_conversio_a_array_per_a_serialitzacio(): void
    {
        $producte = new Producte(
            nom: 'Gorra Running',
            descripcio: 'Transpirable',
            preu: 15.00,
            iva: 21.0,
            color: 'Negre',
            talla: 'Única'
        );

        $array = $producte->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('Gorra Running', $array['nom']);
        $this->assertEquals('15.00', $array['preu']);
        $this->assertEquals('18.15', $array['preu_iva']);
    }

    public function test_acces_a_propietats_de_objecte(): void
    {
        $producte = new Producte(
            nom: 'Botes Muntanya',
            descripcio: 'Impermeables',
            preu: 80.00,
            iva: 21.0,
            color: 'Marró',
            talla: '42'
        );

        $this->assertEquals('Botes Muntanya', $producte->nom);
        $this->assertEquals('Marró', $producte->color);
        $this->assertEquals('42', $producte->talla);
    }

    public function test_assignacio_de_id(): void
    {
        $producte = new Producte(
            id: 5,
            nom: 'Bufanda Llana',
            descripcio: 'Càlida',
            preu: 12.00
        );

        $this->assertEquals(5, $producte->id);
        $array = $producte->toArray();
        $this->assertEquals(5, $array['id']);
    }
}
