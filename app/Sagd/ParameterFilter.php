<?php

namespace Sagd;

use App;
use Illuminate\Http\Request;

trait ParameterFilter {

    /**
     * @param LGGModel $model
     * @param Request $request
     */
    public function filter($model, Request $request)
    {
        $params = $request->all();
        $modifiedParams = [];

        foreach ($params as $tableCol => $value) {
            $table_col = explode('_', $tableCol);
            $arr = [$table_col[0] => [$table_col[1] => $value]];
            $modifiedParams = array_merge($modifiedParams, $arr);
        }

        foreach ($modifiedParams as $table => $columnValue) {
            $model = $model->whereHas($table, function($query) use ($columnValue) {
               $column = key($columnValue);
               $value = current($columnValue);
               $query->where($column, $value);
            });
        }

        return $model->get();
    }
}
