<?php
namespace Sagd;
use \DB;

trait SafeTransactions {

    public function safe_transaction($function)
    {
        DB::beginTransaction();
        $result = call_user_func($function);
        if ( gettype($result) === 'boolean' && $result ) {
            DB::commit();
            return true;
        } else {
            DB::rollback();
            return false;
        }
    }
}
