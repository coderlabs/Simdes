<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/16/2014
     * Time: 20:02
     */

    namespace Simdes\Models\RKPDesa;


    use Illuminate\Database\Eloquent\Model;

    /**
     * Class IndikatorManfaat
     *
     * @package Simdes\Models\RKPDesa
     */
    class IndikatorManfaat extends Model
    {
        /**
         * @var bool
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'tb_indikator_manfaat';
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