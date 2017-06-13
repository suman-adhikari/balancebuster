<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 09/01/2016
 * Time: 22:45
 */

namespace System\MVC;

class Model {
    public function MapParameters($params, $nullEmpty = false)
    {
        foreach ($params as $key => $val) {
            if (property_exists($this, $key)) {
                if ($nullEmpty && $val == '') {
                    $this->$key = null;
                } else {
                    $this->$key = trim($val);
                }
            }
        }
    }

}