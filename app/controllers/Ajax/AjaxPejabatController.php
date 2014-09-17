<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 13:58
 */

namespace Ajax;

use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AjaxPejabatController
 * @package Ajax
 */
class AjaxPejabatController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        PejabatDesaRepositoryInterface $pejabat,
        UserRepositoryInterface $auth
    )
    {
        $this->auth = $auth;
        $this->pejabat = $pejabat;
    }

    /**
     * @return array
     */
    public function getPejabatDesa()
    {

        $data = $this->pejabat->getList($this->auth->getOrganisasiId());
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'           => $value->id,
                    'pejabat_desa' => $value->nama . " - " . $value->jabatan,
                ];
            }
        } else {
            $result[] = "";
        }

        return $result;
    }

} 