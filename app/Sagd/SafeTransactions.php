<?php
namespace Sagd;
use \DB;

trait SafeTransactions {

    public function safe_transaction($function)
    {
        DB::beginTransaction();

        if ( call_user_func($function) ) {
            DB::commit();
            return true;
        } else {
            DB::rollback();
            return false;
        }
    }
}
