<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 16/01/2016
 * Time: 09:02
 */
namespace Shared\AjaxGrid;

use System\MVC\ModelAbstract;

class AjaxModel extends ModelAbstract {

    public $offset;

    public $rowNumber;

    public $sortExpression;

    public $sortOrder;

    public $pageNumber;

    public $advanceSorting;

}