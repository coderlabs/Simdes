<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/16/2014
     * Time: 19:53
     */

    namespace Simdes\Models\RKPDesa;


    use Illuminate\Database\Eloquent\Model;


    /**
     * Class IndikatorKeluaran
     *
     * @package Simdes\Models\RKPDesa
     */
    class IndikatorKeluaran extends Model
    {

        /**
         * @var bool
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'tb_indikator_keluaran';
        /**
         * @var array
         */
        protected $fillable = [
            'rkpdesa_id',
            'tolok_ukur',
            'target',
            'satuan',
            'user_id',
            'organisasi_id'
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function rkpdesa()
        {
            return $this->belongsTo('Simdes\Models\RKPDesa\RKPDesa', 'rkpdesa_id');
        }


    }