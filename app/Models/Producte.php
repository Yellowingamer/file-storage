<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use DOMDocument;

class Producte
{
    public const FITXER_JSON = 'productes.json';
    public const FITXER_XML = 'productes.xml';

    public int $id = 0;
    public string $nom = '';
    public string $descripcio = '';
    public float $preu = 0.0;
    public float $iva = 21.0;
    public float $preu_iva = 0.0;
    public string $color = '';
    public string $talla = '';
    public string $data_registre = '';

    public function __construct(
        string $nom = '',
        string $descripcio = '',
        float $preu = 0.0,
        float $iva = 21.0,
        string $color = '',
        string $talla = '',
        int $id = 0
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->descripcio = $descripcio;
        $this->preu = (float) $preu;
        $this->iva = (float) $iva;
        $this->color = $color;
        $this->talla = $talla;
        $this->preu_iva = $this->calcularPreuAmbIva();
        $this->data_registre = now()->format('Y-m-d H:i:s');
    }

    public function calcularPreuAmbIva(): float
    {
        return round($this->preu * (1 + ($this->iva / 100)), 2);
    }

    public function getPreuFormatejat(): string
    {
        return number_format($this->preu, 2, '.', '');
    }

    public function getPreuIvaFormatejat(): string
    {
        return number_format($this->preu_iva, 2, '.', '');
    }

    public function getIvaFormatejat(): string
    {
        return number_format($this->iva, 2, '.', '');
    }

    public function assegurarId(): void
    {
        if ($this->id <= 0) {
            $this->id = self::generarSeguentId();
        }
    }

    public static function generarSeguentId(): int
    {
        $maxId = 0;

        foreach (self::obtenirDeJson() as $prod) {
            if ($prod->id > $maxId) {
                $maxId = $prod->id;
            }
        }

        foreach (self::obtenirDeXml() as $prod) {
            if ($prod->id > $maxId) {
                $maxId = $prod->id;
            }
        }

        return $maxId + 1;
    }

    public function guardarEnJson(): void
    {
        $this->assegurarId();

        $llista = self::obtenirDeJson();
        $llista[] = $this;

        $dades = [];
        foreach ($llista as $p) {
            $dades[] = $p->toArray();
        }

        Storage::disk('local')->put(
            self::FITXER_JSON,
            json_encode($dades, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function guardarEnXml(): void
    {
        $this->assegurarId();

        $llista = self::obtenirDeXml();
        $llista[] = $this;

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><productes></productes>');
        foreach ($llista as $p) {
            $node = $xml->addChild('producte');
            $node->addChild('id', (string) $p->id);
            $node->addChild('nom', htmlspecialchars($p->nom));
            $node->addChild('descripcio', htmlspecialchars($p->descripcio));
            $node->addChild('preu', $p->getPreuFormatejat());
            $node->addChild('iva', $p->getIvaFormatejat());
            $node->addChild('preu_iva', $p->getPreuIvaFormatejat());
            $node->addChild('color', htmlspecialchars($p->color));
            $node->addChild('talla', htmlspecialchars($p->talla));
            $node->addChild('data_registre', $p->data_registre);
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        Storage::disk('public')->put(self::FITXER_XML, $dom->saveXML());
    }

    public static function fromArray(array $dades): Producte
    {
        $p = new Producte();
        $p->id = isset($dades['id']) ? (int) $dades['id'] : 0;
        $p->nom = $dades['nom'] ?? '';
        $p->descripcio = $dades['descripcio'] ?? '';
        $p->preu = (float) ($dades['preu'] ?? 0);
        $p->iva = (float) ($dades['iva'] ?? 21);
        $p->color = $dades['color'] ?? '';
        $p->talla = $dades['talla'] ?? '';
        $p->preu_iva = isset($dades['preu_iva']) ? (float) $dades['preu_iva'] : $p->calcularPreuAmbIva();
        $p->data_registre = $dades['data_registre'] ?? now()->format('Y-m-d H:i:s');

        return $p;
    }

    public static function fromXml(SimpleXMLElement $item): Producte
    {
        $p = new Producte();
        $p->id = isset($item->id) ? (int) $item->id : 0;
        $p->nom = (string) $item->nom;
        $p->descripcio = (string) $item->descripcio;
        $p->preu = (float) $item->preu;
        $p->iva = (float) $item->iva;
        $p->preu_iva = (float) $item->preu_iva;
        $p->color = (string) $item->color;
        $p->talla = (string) $item->talla;
        $p->data_registre = (string) ($item->data_registre ?? '-');

        return $p;
    }

    public static function obtenirDeJson(): array
    {
        if (!Storage::disk('local')->exists(self::FITXER_JSON)) {
            return [];
        }

        $contingut = Storage::disk('local')->get(self::FITXER_JSON);
        $dades = json_decode($contingut, true);

        if (!is_array($dades)) {
            return [];
        }

        $productes = [];
        foreach ($dades as $index => $item) {
            $producte = self::fromArray($item);
            if ($producte->id <= 0) {
                $producte->id = $index + 1;
            }
            $productes[] = $producte;
        }

        return $productes;
    }

    public static function obtenirDeXml(): array
    {
        if (!Storage::disk('public')->exists(self::FITXER_XML)) {
            return [];
        }

        $contingut = Storage::disk('public')->get(self::FITXER_XML);
        $xml = @simplexml_load_string($contingut);

        if (!$xml || !isset($xml->producte)) {
            return [];
        }

        $productes = [];
        $index = 1;
        foreach ($xml->producte as $item) {
            $producte = self::fromXml($item);
            if ($producte->id <= 0) {
                $producte->id = $index;
            }
            $productes[] = $producte;
            $index++;
        }

        return $productes;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'descripcio' => $this->descripcio,
            'preu' => $this->getPreuFormatejat(),
            'iva' => $this->getIvaFormatejat(),
            'preu_iva' => $this->getPreuIvaFormatejat(),
            'color' => $this->color,
            'talla' => $this->talla,
            'data_registre' => $this->data_registre,
        ];
    }
}
