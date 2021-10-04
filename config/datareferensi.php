<?php


return [
    // data referensi kelompok pegawai
    'kelompok_pegawai'     =>   [
        'dokter'                => 'Dokter',
        'perawat'               => 'Perawat',
        'administrasi'          => 'Administrasi',
        'penunjang medis'       => 'Penunjang Medis',
        'security'              => 'Security',
        'non medis'             => 'Non Medis',
        'bidan'                 => 'Bidan',
        'dokter radioterapi'    => 'Dokter Radioterapi',
        'farmasi'               => 'Farmasi',
        'dokter luar'           => 'Dokter Luar',
        'terapis'               => 'Terapis',
        'supir'                 => 'Supir',
        'radiografer'           => 'Radiografer',
        'direkur'               => 'Direkur',
        'keuangan'              => 'Keuangan',
    ],

    // data referensi agama
    'agama'                 => [
        'islam'                 => 'Islam',
        'protestan'             => 'Protestan',
        'katolik'               => 'Katolik',
        'hindu'                 => 'Hindu',
        'buddha'                => 'Buddha',
        'khonghucu'             => 'Khonghucu',

    ],

    // data referensi jenjang pendidikan
    'jenjang_pendidikan'    => [
        'TK'                    => 'TK',
        'SD'                    => 'SD',
        'SMP'                   => 'SMP',
        'SMA/SMK/SMU'           => 'SMA/SMK/SMU',
        'Perguruan Tinggi'      => 'Perguruan Tinggi',
    ],

    'status_pernikahan'    => [
        'sudah menikah'         => 'Sudah Menikah',
        'belum menikah'         => 'Belum Menikah',
    ],
    'kewarganegaraan'    => [
        'WNI'         => 'WNI',
        'WNA'         => 'WNA',
    ],
    'golongan_darah'    => [
        '-'         => 'Belum Diperiksa',
        'A'         => 'A',
        'B'         => 'B',
        'AB'        => 'AB',
        'O'         => 'O',
    ],
    'privilage_khusus'    => [
        'tidak'         => 'TIDAK',
        'tunanetra'     => 'Tunanetra',
        'tunarungu'     => 'Tunarungu',
        'tunawicara'    => 'Tunawicara',
        'tunadaksa'     => 'Tunadaksa',
        'tunagrahita'   => 'Tunagrahita',
        'tunalaras'     => 'Tunalaras',
        'autis'         => 'Autis',
    ],
    'hubungan_pasien'   => [
        'pasien'        => 'PASIEN',
        'istri'         => 'ISTRI',
        'suami'         => 'SUAMI',
        'ayah'          => 'AYAH',
        'ibu'           => 'IBU',
        'anak'          => 'ANAK',
        'saudara'       => 'SAUDARA'
    ],
    'penjamin'    => [
        'umum'                      => 'UMUM',
        'PT.INKORDAN'               => 'PT.INKORDAN',
        'PT.IWON APPAREL INDONESIA' => 'PT.IWON APPAREL INDONESIA',
        'PT.MITRAIDA'               => 'PT.MITRAIDA',
        'PT.OASIS'                  => 'PT.OASIS',
        'PT.SERENA INDOPANGAN'      => 'PT.SERENA INDOPANGAN',
        'PT.SUPER GRAHA MAKMUR'     => 'PT.SUPER GRAHA MAKMUR',
        'PT.SUPER GRAHA MAKMUR Hj'  => 'PT.SUPER GRAHA MAKMUR Hj',
        'PT.SUPER GRAHA MAKMUR MRH' => 'PT.SUPER GRAHA MAKMUR MRH',
        'PT.UNIMAKMUR'              => 'PT.UNIMAKMUR',
    ],
    'status_kehadiran'    => [
        'hadir'        => 'Hadir',
        'tidak hadir'  => 'Tidak Hadir',
        'izin'         => 'Izin',
        'sakit'        => ' Sakit'
    ],


    'user_role'            => [
        'administrator' =>  'Administrator',
        'pimpinan'      =>  'Pimpinan',
        'dokter'        =>  'Dokter',
        'kasir'         =>  'Kasir',
        'keuangan'      =>  'Keuangan',
        'hrd'           =>  'HRD',
        'bagian_pendaftaran' => 'Bagian Pendaftaran',
        'admin_medis'   =>  'Admin Medis',
        'bagian_gudang' => 'Bagian Gudang'
    ],
    'jenis_barang'          => [
        'obat'  =>  'Obat',
        'alkes' =>  'Alkes'
    ],
    'hari'                  => [
        'senin'     => 'Senin',
        'selasa'    => 'Selasa',
        'rabu'      => 'Rabu',
        'kamis'     => 'kamis',
        'jumat'     => 'Jumat',
        'sabtu'     => 'Sabtu',
        'minggu'    => 'Minggu'
    ],
    'jenis_kategori'        => [
        'obat_alkes'    =>  'Obat Dan Alkes',
        'tindakan'      =>  'Tindakan'
    ],

    'kelompok_pasien' => [
        'umum'      =>  'Umum',
        'non_umum'  =>  'Non Umum'
    ],

    'status_po' => [
        'pengajuan_po'          =>  'Pengajuan Purchase Order',
        'approve_by_pimpinan'   =>  'Approve Oleh Pimpinan',
        'reject_by_pimpinan'    =>  'Ditolak Oleh Pimpinan',
        'selesai_po'            =>  'Selesai'
    ],
    'jenis_pendaftaran' => [
        'daftar langsung' => 'DAFTAR LANGSUNG',
        'via telepon'     => 'VIA TELEPON'
    ],
    'jenis_rujukan'     => [
        'datang sendiri'    => 'DATANG SENDIRI',
        'puskesmas'         => 'PUSKESMAS',
        'rumah sakit luar'  => 'RUMAH SAKIT LUAR',
        'dokter luar'       => 'DOKTER LUAR',
        'bidan'             => 'BIDAN',
        'faskes lainnya'    => 'FASKES LAINNYA',
        'rujukan non medis' => 'RUJUKAN NON MEDIS'
    ],
];
