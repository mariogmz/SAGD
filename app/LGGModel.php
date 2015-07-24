<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class LGGModel extends Model
{

    /**
     * This method is responsible for validating the model
     *
     * @return bool
     */
    public function isValid()
    {
        $validation = Validator::make($this->attributes, static ::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();
        return false;
    }

    public static function scopeLast($query)
    {
        return $query->orderBy('id', 'desc')->first();
    }
}
