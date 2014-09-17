<?php
    /**
     * Created by PhpStorm.
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/13/2014
     * Time: 10:39
     */

    namespace Simdes\Models\Belanja;


    use Illuminate\Database\Eloquent\Model;

    /**
     * Class Belanja
     *
     * @package Simdes\Models\Belanja
     */
    class Belanja extends Model
    {
        /**
         * @var bool
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'tb_belanja';
        /**
         * @var array
         */
        protected $fillable = [
            'user_id',
            'tahun',
            'kelompok_id',
            'jenis_id',
            'obyek_id',
            'rincian_obyek_id',
            'volume_1',
            'volume_2',
            'volume_3',
            'satuan_1',
            'satuan_2',
            'satuan_3',
            'jumlah',
            'belanja',
            'satuan_harga',
            'organisasi_id',
            'kegiatan_id',
            'kegiatan',
            'rkpdesa_id',
            'pagu_anggaran',
            'jenis_belanja'
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function kelompok()
        {
            return $this->belongsTo('Simdes\Models\Akun\Kelompok', 'kelompok_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function jenis()
        {
            return $this->belongsTo('Simdes\Models\Akun\Jenis', 'jenis_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function obyek()
        {
            return $this->belongsTo('Simdes\Models\Akun\Obyek', 'obyek_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function rincianObyek()
        {
            return $this->belongsTo('Simdes\Models\Akun\RincianObyek', 'rincian_obyek_id');
        }
    }