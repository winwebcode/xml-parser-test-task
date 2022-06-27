<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\XmlParser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $xml = new XmlParser();
        $goods = new Goods();
        $goods->data = $xml->getData()->parser(); //get XML and parse
        $goods->saveData(); //save goods
    }
}
