<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Goods extends Model
{
    use HasFactory;

    protected $table = 'goods';
    protected $fillable = [
        'serial_number',
        'code',
        'storage',
        'region',
        'engineer_comment',
        'reason_discount_expand',
        'condition',
        'guarantee_cancel_date',
        'serviceability',
        'kit',
        'name',
        'images',
        'original_price',
    ];
    /**
     * @var mixed
     */
    public $data;


    public function saveData(): void
    {
        foreach ($this->data as $item) {
            Goods::updateOrInsert(
                ['serial_number' => $item->СерийныйНомер],
                ['code' => (int) $item->КодТовара,
                'storage' => $item->Склад,
                'region' => $item->Регион,
                'engineer_comment' => $item->КомментарийИнженера,
                'reason_discount_expand' => $item->ПричинаУценкиРазвернуто,
                'condition' => $item->Состояние,
                'guarantee_cancel_date' => Carbon::parse($item->ДатаОкончанияГарантии),
                'serviceability' => $item->Работоспособность,
                'kit' => $item->Комплект,
                'name' => $item->name,
                'images' => $item->images,
                'original_price' => $item->price]
            );
        }
    }
}
