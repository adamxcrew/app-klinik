<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienStoreRequest extends FormRequest
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
            'nomor_ktp'         =>  'required|integer|min:16',
            'nama'              =>  'required',
            'nomor_hp'          =>  'required',
            'alamat'            =>  'required',
            'rt_rw'             =>  'required',
            'pekerjaan'         =>  'required',
            'pendidikan'        =>  'required',
            'nama_ibu'          =>  'required',
        ];
    }
}
