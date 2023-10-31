<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use DateTimeInterface;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'description',
        'price_including_tax',
        'released_at',
        'user_id'
    ];

    protected $appends = ['save_interval'];

    /**
     * 商品画像テーブルと関連付ける
     *
     * @access public
     * @return HasMany
     */
    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * ブランドテーブルと関連付ける
     *
     * @access public
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * カテゴリーテーブルと関連付ける
     *
     * @access public
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * クチコミテーブルと関連付ける
     *
     * @access public
     * @return BelongsToMany
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reviews')
            ->withPivot('id', 'score', 'text')
            ->orderBy('pivot_id', 'desc');
    }

    /**
     * 作成日を東京時間に変更する
     *
     * JSONデータの作成日がUTC時間のため、東京時間に変更する。
     * 
     * @return String
     */
    protected function serializeDate(DateTimeInterface $date): String
    {
        return $date->format('Y-m-d');
    }

    /**
     * 保存期間を取得する
     *
     * @access public
     * @return String
     */
    public function saveInterval(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans(Carbon::now())
        );
    }
}
