<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/16/2014
 * Time: 12:17
 */

namespace Perdes;

use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AjaxPerdes
 * @package Perdes
 */
class AjaxPerdes extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    protected $judul;

    /**
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     */
    public function __construct(
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->judul = $judul;
    }

    /**
     * @return array
     */
    public function getJudul()
    {
        $data = $this->judul->getList($this->auth->getOrganisasiId());
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'    => $value->id,
                    'judul' => $value->judul
                ];
            }
        } else {
            $result[] = "";
        }

        return $result;
    }
}