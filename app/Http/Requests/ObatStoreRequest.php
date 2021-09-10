<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObatStoreRequest extends FormRequest
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
            'kode'      =>  'required',
            'nama_obat' =>  'required',
            'harga'     =>  'required|integer',
            'satuan_id' =>  'required',
            'status'    =>  'required',
            'status'   =>  'required'
        ];
    }
}
