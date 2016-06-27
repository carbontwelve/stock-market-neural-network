<?php namespace App;

use Forestry\Orm\BaseModel;

/**
 * Class Stock
 * @package App
 *
 * @property int id
 * @property string created_at
 * @property string symbol
 * @property float last_value
 * @property int last_value_delta
 */
class Stock extends BaseModel {

    /**
     * @var string
     */
    public static $table = 'stocks';

}