<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 29/09/2014
 * Time: 9:28
 */

namespace Ajax;


use Simdes\Models\SumberDana\SumberDana;
use Simdes\Repositories\SumberDana\SumberdanaInterface;

class AjaxSumberDana extends \BaseController{

    protected $sumberDana;

    public function __construct(SumberdanaInterface $sumberDana){
        $this->sumberDana = $sumberDana;
    }

    public function getList(){
        return $this->sumberDana->getList();
    }

}