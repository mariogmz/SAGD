<?php

namespace Sagd;

interface BulkUpdates {

    public function bulkUpdate($updatableField, $searchableField, array $values);
}
