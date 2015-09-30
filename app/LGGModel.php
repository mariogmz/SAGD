<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * App\LGGModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class LGGModel extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['deleted_at'];

    public $errors;

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

    public function self() {
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * This method will try the default delete method but if it throws an
     * exception will return false instead of the Exception
     *
     * @return bool
     */
    public function delete()
    {
        try
        {
            return parent::delete();
        }
        catch (\Illuminate\Database\QueryException $queryException)
        {
            return false;
        } catch (Exception $exception)
        {
            return false;
        }
    }
}
