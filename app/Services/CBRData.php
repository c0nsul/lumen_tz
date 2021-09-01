<?php

namespace App\Services;

use DOMDocument;
use Illuminate\Support\Str;

class CBRData
{
    protected $data = [];

    /**
     * @param null $date
     * @return bool
     */
    public function load($date = null)
    {
        $url = "http://cbr.ru/scripts/XML_daily.asp";
        if ($date) {
            $dateStr = strtotime($date);
            $url = $url . "?date_req=" . date("d/m/Y", $dateStr);
        }

        $xml = new DOMDocument();
        if ($xml->load($url)) {
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName("Valute");
            foreach ($items as $item) {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $digiCode = $item->getElementsByTagName('NumCode')->item(0)->nodeValue;
                $name = $item->getElementsByTagName('Name')->item(0)->nodeValue;
                $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;

                $this->data[$code] = [
                    'alphabetic_code' => $code,
                    'digital_code' => $digiCode,
                    'name' => $name,
                    'rate' => $curs,
                    'english_name' => Str::slug($name),
                ];
            }

            return true;
        }
        return false;
    }

    public function getCurrencyAll(): array
    {
        return $this->data;
    }

    /**
     * @param $cur
     * @return array|mixed
     */
    public function getCurrency($cur)
    {
        return $this->data[$cur] ?? [];
    }
}
