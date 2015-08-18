<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * App\LGGModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class LGGModel extends Model {

    /**
     * This method is responsible for validating the model
     * @codeCoverageIgnore
     * @return bool
     */
    public function isValid($method = null) {
        $rules = is_null($method) ? static::$rules : $this->updateRules;
        $validation = Validator::make($this->attributes, $rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();

        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function scopeLast($query) {
        return $query->orderBy('id', 'desc')->first();
    }
}
