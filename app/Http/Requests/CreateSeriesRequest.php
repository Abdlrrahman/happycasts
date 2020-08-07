<?php

namespace HappyCasts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use HappyCasts\Series;

class CreateSeriesRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ];
    }

    public function uploadSeriesImage()
    {
        $uploadedImage = $this->image;
        //upload file
        $this->fileName = str_slug($this->title) . '.' . $uploadedImage->getClientOriginalExtension();
        $uploadedImage->storePubliclyAs(
            'series',
            $this->fileName

        );

        return $this;
    }

    public function storeSeries()
    {
        //create series
        Series::create([
            'title' => $this->title,
            'description' => $this->description,
            'slug' => str_slug($this->title),
            'image_url' => 'series/' . $this->fileName
        ]);
    }
}
