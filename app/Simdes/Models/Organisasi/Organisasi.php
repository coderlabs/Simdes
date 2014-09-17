<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/15/2014
     * Time: 18:55
     */

    namespace Simdes\Models\Organisasi;


    use Illuminate\Database\Eloquent\Model;

    /**
     * Class Organisaasi
     *
     * @package Simdes\Models\Organisasi
     */
    class Organisasi extends Model
    {

        /**
         * @var bool
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'tb_organisasi';
        /**
         * @var array
         */
        protected $fillable = [
            'nama',
            'alamat',
            'desa',
            'kode_kec',
            'kec',
            'kode_kab',
            'kab',
            'kode_prov',
            'prov',
            'no_telp',
            'fax',
            'email',
            'website',
            'kode_desa',
            'logo',
            'slug'
        ];

        public function pejabatDesa()
        {
            return $this->belongsTo('Simdes\Models\Pejabat\PejabatDesa', 'organisasi_id');
        }

    }