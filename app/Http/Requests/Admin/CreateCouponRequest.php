<?php
/**
 * 创建优惠券
 */

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateCouponRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required',
            'date_start'       => 'required_without:got_expire_day|date_format:Y-m-d H:i:s',
            'date_end'         => 'required_without:got_expire_day|date_format:Y-m-d H:i:s|after:date_start',
            'got_expire_day'   => 'required_without:date_start,date_end|integer|min:0',
            'with_store'       => 'required_without:without_store|array',
            'without_store'    => 'required_without:with_store|array',
            'use_limit'        => 'required|integer|min:0',
            'use_amount_total' => 'required_without:use_amount_per|numeric|min:0',
            'use_amount_per'   => 'required_without:use_amount_total|numeric|min:0',
            'with_category'    => 'required_without:without_category|array',
            'without_category' => 'required_without:with_category|array',
            'with_product'     => 'required_without:without_product|array',
            'without_product'  => 'required_without:with_category|array',
        ];
    }

}