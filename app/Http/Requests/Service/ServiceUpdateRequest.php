<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
      'category_id' => 'required|exists:categories,id',
      'title' => 'required|string|min:1|max:255',
      'text' => 'required|string',
      'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp',
      'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp',
      'date_from' => 'nullable|string',
      'date_to' => 'nullable|string',
      'status' => 'nullable|string',
      'price' => 'nullable|integer',
      'is_priced' => 'required|boolean',
      'address' => 'required|max:255',
      'city_id' => 'required|exists:cities,id',
      'district_id' => 'nullable|exists:districts,id',
      'seo_description' => 'nullable|string|max:255',
      'keywords' => 'nullable|string|max:255',
      'meta' => 'array|nullable'
    ];
  }
}
