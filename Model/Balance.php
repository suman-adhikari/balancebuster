<?php
/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 5/29/2017
 * Time: 8:40 AM
 */

namespace Model;


use System\MVC\ModelAbstract;

class Balance extends ModelAbstract {
  public $Id;
  public $Action;
  public $Amount;
  public $reason;
  public $date;
  public $currentAmount;

}