<?php

namespace App\Models;

use Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATISTICS_TYPES = ['count', 'avg', 'website_max_price', 'price_in_current_month'];

    /**
     * Set the items's description.
     *
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

        $this->attributes['description'] = trim($converter->convert($value)->getContent());
    }

    /**
     * Get the statistic's for items
     *
     * @param string $type = *
     * @return array $data
     */
    public static function statistics(string $type = "*"): array
    {
        $data = [];

        if (!in_array($type, static::STATISTICS_TYPES)) {
            $type = "*";
        }

        if ($type == "*" || $type == "count") {
            $data['count'] = static::count('*');
        }

        if ($type == "*" || $type == "avg") {
            $data['avg'] =  number_format(static::avg('price'), 2, '.', ' ');
        }

        if ($type == "*" || $type == "website_max_price") {
            $result = static::select('url')->groupBy('url')->orderBy(DB::raw('sum(price)'), 'desc')->first();
            $data['website_max_price'] = $result ? parse_url($result->url)['host'] : null;
        }

        if ($type == "*" || $type == "price_in_current_month") {
            $result = static::select(DB::raw('sum(price) total'))->whereYear('created_at', \date('Y'))
                ->whereMonth('created_at', \date('m'))->first();

            $data['price_in_current_month'] = $result ? number_format($result->total, 2, '.', ' ') : null;
        }

        return $data;
    }
}
