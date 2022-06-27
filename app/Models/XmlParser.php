<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use SimpleXMLElement;

class XmlParser extends Model
{
    use HasFactory;

    public const URL = 'https://api.iport.ru/files/xml/TradeIn_markdown.xml';
    public $itemURL = 'https://stage.api.iport.ru/api/products/';
    /**
     * @var mixed
     */
    private $curl;
    /**
     * @var bool|mixed|string
     */
    private $response;
    /**
     * @var mixed
     */
    private $item;
    /**
     * @var mixed
     */
    private $fullItem;

    public function getData(): XmlParser
    {
        $this->curl = curl_init();

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $this->response = curl_exec($this->curl);

        if (self::checkResponse()) {
            return $this;
        } else {
            throw new Exception("XML данные не получены! Нет смысла продолжать выполнение.");
        }
    }

    public function checkResponse(): bool
    {
        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            return false;
        }
        curl_close($this->curl);
        return true;
    }

    public function parser()
    {
        $xmlData = new SimpleXMLElement($this->response);
        foreach ($xmlData as $this->item) {
            if ($this->existFullInfoAboutItem()) {
                $this->item->name = (string) $this->fullItem->data->TITLE;
                $this->item->images = implode(", ", $this->fullItem->data->IMAGES);
                $this->item->price = (float) $this->fullItem->data->PRICE->VALUE;
            } else {
                $this->item->name = (string) $this->item->КодТовара[0];
            }
        }
        return $xmlData;
    }

    public function existFullInfoAboutItem(): bool
    {
        $itemCode = (string) $this->item->КодТовара[0];
        $this->fullItem = json_decode(file_get_contents($this->itemURL . $itemCode)); //get full info by item code
        if (!isset($this->fullItem->data)) {
            return false;
        } else {
            return true;
        }
    }
}
