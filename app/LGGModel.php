<?php

namespace App;

use Exception;
use Sagd\BulkUpdates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * App\LGGModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class LGGModel extends Model implements BulkUpdates{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['deleted_at'];

    public $errors;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

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

    /**
     * Realiza un query que ejecuta un update masivo usando CASE-END
     * @param $updatableField
     * @param $searchableField
     * @param array $values
     * @return bool
     */
    public function bulkUpdate($updatableField, $searchableField, array $values)
    {
        if ($this->checkCorrectArrayForBulkUpdate($values) < 0) {
            return false;
        }

        $collection = collect($values);
        $collection = $this->prepareValuesForBulkUpdate($collection);

        $statement = sprintf("UPDATE %s SET %s = (CASE %s %s END) WHERE %s IN ( %s );",
            $this->table, $updatableField, $searchableField, $collection->implode(' '),
            $searchableField, $collection->keys()->implode(','));
        return $this->performBulkUpdateWith($statement);
    }

    /**
     * Revisa que el array que se envio sea apropiado para el bulk insert
     * @param $values
     * @return void
     * @throws InvalidArrayForBulkUpdateException
     */
    protected function checkCorrectArrayForBulkUpdate($values)
    {
        if (count($values) === 0) {
            return -1;
        }
    }

    /**
     * Modifica la colección de valores para que tengan en formato de SQL que se necesita
     * @param $collection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function prepareValuesForBulkUpdate($collection)
    {
        return $collection->map(function ($item, $key){
            return "WHEN $key THEN \"$item\"";
        });
    }

    /**
     * Realiza la llamada en la base de datos
     * @param $statement
     * @return int
     */
    protected function performBulkUpdateWith($statement)
    {
        $connection = $this->getConnection();
        return $connection->update($statement);
    }

    /**
     * @param array $conditions
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildQuery(array $conditions){
        $builder = $this;
        foreach($conditions as $condition){
            $builder = $builder->where($condition['field'], $condition['operator'] ?: '=', $condition['value']);
        }
        return $builder;
    }
}
