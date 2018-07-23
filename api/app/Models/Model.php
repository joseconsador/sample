<?php

namespace App\Models;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Array of strings representing relations available to this model.
     *
     * @var array
     */
    protected $exportableRelations = [];

    /**
     * Returns the relations that are valid for this model.
     *
     * @return array
     */
    public function getExportableRelations()
    {
        return $this->exportableRelations;
    }
}
