<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|max:300|string',
            'category' => 'required|string', 
            'quantity' => 'required|numeric',
            'description'=>'required|string',
            'price'=>'required|integer|min:10000',
            'image'=>'required|filled|image|mimes:jpeg,png,jpg,gif,svg|max:25000',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Bạn chưa nhập tên đồ',
            'name.max'=>'Tên đồ chỉ có tối đa 300 ký tự',
            'category.required' => 'Bạn chưa nhập category',
            'category.string' => 'category phải là chữ',
            'quantity'=>'Bạn chưa nhập quantity',
            'description.required'=>'Bạn chưa nhập mô tả ',
            'price.required'=>'Bạn chưa nhập unit price',
            'price.min'=>'unit price phải lớn hơn 10000 đ',
            'image.required'=>'Bạn chưa chọn ảnh',
            'image.filled'=>'Bạn chưa chọn ảnh',
            'image.max'=>'Kích thước ảnh tối đa là 25Mb',
            'image.image'=>'File bạn upload không phải ảnh',
        ];
}
}
