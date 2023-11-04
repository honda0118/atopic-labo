<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use DateTimeInterface;

/**
 * @property int $user_id
 */
class Review extends Pivot
{
    use HasFactory;

    /**
     * 作成日を東京時間に変更する
     *
     * JSONデータの作成日がUTC時間のため、東京時間に変更する。
     * 
     * @return String
     */
    protected function serializeDate(DateTimeInterface $date): String
    {
        return $date->format('Y-m-d H:i:s');
    }
}
