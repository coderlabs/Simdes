<?php
    /**
     * Created by PhpStorm.
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/12/2014
     * Time: 19:22
     */

    namespace Simdes\Models\Pembiayaan;


    use Illuminate\Database\Eloquent\Model;

    /**
     * Class Pembiayaan
     *
     * @package Simdes\Models\Pembiayaan
     */
    class Pembiayaan extends Model
    {

        /**
         * @var string
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'tb_pembiayaan';
        /**
         * @var array
         */
        protected $fillable = ['user_id', 'pembiayaan', 'tahun', 'kelompok_id', 'kelompok', 'jenis_id', 'jenis', 'obyek_id', 'obyek', 'rincian_obyek_id', 'volume_1', 'volume_2', 'volume_3', 'satuan_1', 'satuan_2', 'saatuan_3', 'jumlah'];

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