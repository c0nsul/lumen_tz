<?php

namespace App\Services;

use DOMDocument;
use DOMNodeList;

class CBRData
{
    protected $data = [];
    private DOMDocument $xml;

    public function __construct()
    {
        $this->xml = new DOMDocument();
    }

    /**
     * @param null $date
     * @return bool
     */
    public function loadCurrencies($date = null)
    {
        $urlLibs = env('CURRENCY_ENG_API_URI');
        $engNamesArray = [];

        $items = $this->fetchCurrencies($urlLibs);
        if ($items) {
            foreach ($items as $item) {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $engNamesArray[$code] = $item->getElementsByTagName('Name')->item(0)->nodeValue;
            }
        } else {
            return false;
        }

        $url = env('CURRENCY_API_URI');
        if ($date) {
            $dateStr = strtotime($date);
            $url = $url . "?date_req=" . date("d/m/Y", $dateStr);
        }

        $items = $this->fetchCurrencies($url);

        if ($items) {
            foreach ($items as $item) {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $digiCode = $item->getElementsByTagName('NumCode')->item(0)->nodeValue;
                $name = $item->getElementsByTagName('Name')->item(0)->nodeValue;
                $value = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $nominal = $item->getElementsByTagName('Nominal')->item(0)->nodeValue;

                $this->data[$code] = [
                    'alphabetic_code' => $code,
                    'digital_code' => $digiCode,
                    'name' => $name,
                    'rate' => round(((int)$nominal / (float)$value), 3, PHP_ROUND_HALF_DOWN),
                    'english_name' => $engNamesArray[$code]
                ];
            }
            return true;
        }
        return false;
    }

    /**
     * @param $uri
     * @return DOMNodeList|false
     */
    private function fetchCurrencies($uri): DOMNodeList|bool
    {
        if ($this->xml->load($uri)) {
            $root = $this->xml->documentElement;
            return $root->getElementsByTagName("Valute");
        }
        return false;
    }

    /**
     * @return array
     */
    public function getCurrencyAll(): array
    {
        return $this->data;
    }
}
