<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 29/09/2014
 * Time: 9:31
 */

namespace Simdes\Repositories\Eloquent\SumberDana;


use Simdes\Models\SumberDana\SumberDana;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SumberDana\SumberdanaInterface;

/**
 * Class SumberDanaRepository
 * @package Simdes\Repositories\Eloquent\SumberDana
 */
class SumberDanaRepository extends AbstractRepository implements SumberdanaInterface{

    /**
     * @param SumberDana $sumberDana
     */
    public function __construct(SumberDana $sumberDana){
        $this->model = $sumberDana;
    }

    /**
     * @return mixed
     */
    public function getList(){
        return $this->model->get(['id','sumber_dana']);
    }

} 