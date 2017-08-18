<?php

/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.08.2017
 * Time: 16:50
 */

class Rate
{
    static $urlCbr = 'http://www.cbr.ru/scripts/XML_daily.asp';
    static $urlYahoo = 'https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDRUB,EURRUB%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

    public $CurrencyCode = 'USD'; //USD code = 840
    public function printRate()
    {
        $rate = 'Not found';
        $cbrRate = $this->getRateFromCbr();
        $rate = $cbrRate ? $cbrRate : 'Not found';
        if ($rate == 'Not found'){
            $YahooRate = $this->getRateFromYahooapis();
            $rate = $YahooRate ? $YahooRate : 'Not found';
        }
        echo $rate;
    }

    private function getRateFromCbr()
    {
        $dom_xml = new DomDocument;
        $dom_xml->load(self::$urlCbr);
        $rates=$dom_xml->getElementsByTagName("Valute");

        foreach ($rates as $curr){
            $one_rate = simplexml_import_dom($curr);
            if ($one_rate->CharCode == $this->CurrencyCode)
            {
                return $one_rate->Value;//.'<br />';
            }
        }
        return false;
    }

    private function getRateFromYahooapis()
    {
        $str = file_get_contents(self::$urlYahoo);
        $rates = json_decode($str, true);
        foreach ($rates['query']['results']['rate'] as $one_rate){
            $pos = strpos($one_rate['Name'],$this->CurrencyCode);
            if ($pos !== false) {
                return $one_rate['Rate'];
            }
        }
        return false;

    }
}
