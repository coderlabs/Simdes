<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 14:41
 */

namespace Ajax;

use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AjaxPendapatan
 * @package Ajax
 */
class AjaxPendapatan extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    protected $pendapatan;
    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    protected $belanja;

    /**
     * @param PendapatanRepositoryInterface $pendapatan
     * @param UserRepositoryInterface $auth
     * @param BelanjaRepositoryInterface $belanja
     */
    public function __construct(
        PendapatanRepositoryInterface $pendapatan,
        UserRepositoryInterface $auth,
        BelanjaRepositoryInterface $belanja
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->pendapatan = $pendapatan;
        $this->belanja = $belanja;
    }

    /**
     * @return array
     */
    public function getPendapatan()
    {
        $term = $this->input('term');
        $data = $this->pendapatan->getList($this->auth->getOrganisasiId(), $term);
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'        => $value->id,
                    'value'     => trim($value->pendapatan),
                    'realisasi' => $value->realisasi,
                ];
            }
        } else {
            $result[] = "";
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getBelanja()
    {
        $term = $this->input('term');
        $data = $this->belanja->autocomplete($this->auth->getOrganisasiId(), $term);
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'        => $value->id,
                    'value'     => trim($value->belanja),
                    'realisasi' => $value->realisasi,
                    'jumlah'    => $value->jumlah,
                ];
            }
        } else {
            $result[] = "";
        }

        return $result;
    }

} 