<?php

namespace HappyCasts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesRequest extends FormRequest
{
    public function uploadSeriesImage()
    {
        $uploadedImage = $this->image;

        $this->fileName = str_slug($this->title) . '.' . $uploadedImage->getClientOriginalExtension();

        $uploadedImage->storePubliclyAs(
            'public/series',
            $this->fileName
        );

        return $this;
    }
}
