<?php

return [
	'welcome_page' => 'Selamat datang di website :name',
	'copyright'	=> 'Copyright :name . All rights Reserved.',
    'verification_email' => 'Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan melalui email kepada Anda? Jika Anda tidak menerima email tersebut, dengan senang hati kami akan mengirimkan email lainnya kepada Anda.',
	'success' => [
		'new_data'		=> 'Data Berhasil Disimpan',
		'edit_data'		=> 'Data :title Berhasil diubah',
		'delete_data'	=> 'Data :title berhasil dihapus!',
        'login'         => 'Anda telah berhasil masuk!',
        'sent_data'     => 'Data telah berhasil dikirim!',
        'request_role'  => 'Anda telah menerima :user untuk mengubah hak akses sebagai :role.',
        'verification_email' => 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.',
	],
	'error' => [
		'new_data'		=> 'Data tidak berhasil disimpan',
		'edit_data'		=> 'Data :title tidak berhasil diubah',
		'delete_data'	=> 'Data :title tidak berhasil dihapus!',
        'login'         => 'Anda gagal masuk!',
        'cancel'        => 'Data :title tidak jadi dibatalkan!.',
        'unverified_email' => 'Maaf, Email Anda belum terverifikasi. Anda akan diarahkan ke halaman verifikasi.',
        'unexpected'    => 'Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silahkan coba lagi!.',
        'request_role'  => 'Tidak ada permintaan untuk mengubah hak akses.',

	],
	'warning' => [
		'no_selected_data' => 'Tidak ada data yang dipilih!',
        'no_data' => 'Data tidak ada',
        'no_notification' => 'Tidak ada notifikasi!',
        'cancel' => 'Anda yakin mau dibatalkan?',
        'request_role'  => 'Permintaan :user untuk mengubah hak akses sebagai :role telah diterima oleh :approver.',
	],
    'notice' => [
        'change_role' => 'Segera Ubah Hak Akses Anda!',
        'role_notif'    => 'Harap diperhatikan bahwa dengan mengubah hak akses pengguna, pengguna tersebut akan kehilangan semua hak istimewa yang ditetapkan untuk hak akses sebelumnya.'
    ],
    'permissions' => [
        'log-viewer' => 'Lihat Aktivitas Log'
    ],
    'notification' => [
        'new_user'  => 'Pengguna :attribute telah melakukan registrasi',
        'role_request' => 'Pengguna :attribute ingin meminta Hak Akses sebagai :attribute2',
        'empty'     => 'Tidak Ada Notifikasi.'
    ]
];
