<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use DateTimeInterface;

/**
 * @property float $avg_score
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'description',
        'price_including_tax',
        'purchase_site',
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
            ->withPivot('id', 'score', 'text', 'created_at')
            ->orderBy('pivot_id', 'desc')
            ->using(Review::class);
    }

    /**
     * いいねテーブルと関連付ける
     *
     * @access public
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * お気に入りテーブルと関連付ける
     *
     * @access public
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
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
     * @return Attribute
     */
    public function saveInterval(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans(Carbon::now())
        );
    }

    /**
     * キーワードで検索するクエリーを返す
     *
     * @access public
     * @param  Builder $query
     * @param  string|null $keyword
     * @return Builder|void
     */
    public function scopeKeyword($query, $keyword)
    {
        if (is_null($keyword)) {
            return;
        }

        // 全角スペースを半角に変換する
        $formatedKeyword = mb_convert_kana($keyword, 's');
        // 空白で区切る
        $keywords = \preg_split('/[\s]+/', $formatedKeyword, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($keywords as $keyword) {
            $query->where(DB::raw("CONCAT(products.name, ' ', products.description, ' ', brands.name, ' ', categories.name)"), 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
