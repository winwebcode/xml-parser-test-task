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
        foreach ($this->data as $this->item) {
            Goods::updateOrInsert(
                ['serial_number' => $this->item->СерийныйНомер],
                ['code' => (int) $this->item->КодТовара,
                'storage' => $this->item->Склад,
                'region' => $this->item->Регион,
                'engineer_comment' => $this->item->КомментарийИнженера,
                'reason_discount_expand' => $this->item->ПричинаУценкиРазвернуто,
                'condition' => $this->item->Состояние,
                'guarantee_cancel_date' => Carbon::parse($this->item->ДатаОкончанияГарантии),
                'serviceability' => $this->item->Работоспособность,
                'kit' => $this->item->Комплект,
                'name' => $this->item->name,
                'images' => $this->item->images,
                'original_price' => $this->item->price]
            );
        }
    }
}
