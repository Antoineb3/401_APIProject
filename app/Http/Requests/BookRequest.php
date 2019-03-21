<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;
use App\Book;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth()->user()->isAdmin()) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Id, Name, ISBN, Publication Year, Publisher, Subscription Status, Timestamp, Image (from amazon)
        return [
            'name' => 'required|min:3',
            'publication_year' => 'required',
            'publisher' => 'required',
            //ISBN we dont want to be editable
            //sub status can be empty to start
            //image can be empty to start 
        ];
    }

    //error messages
    // public function messages()
    // {
    //     return [
    //         'title.required'=>'Title is required',
    //         'title.min:3'=>'Title must be >3 characters',
    //         'body' => 'Body is required',
    //         'published_at.required'=>'Publish date is required',
    //     ];
    // } 
}
