<?php

if (!function_exists('activity_log')) {
    /**
     * Mencatat aktivitas user
     *
     * @param int    $user_id     ID user
     * @param string $title       Judul aktivitas
     * @param string $description Deskripsi aktivitas
     * @param string $type        Jenis aktivitas (misal: login, create, update, delete)
     */
    function activity_log($user_id, $title, $description = '', $type = '') {
        $db = \Config\Database::connect();

        // Ambil data user
        $user = $db->table('users')->where('id', $user_id)->get()->getRow();

        if ($user) {
            $db->table('user_activity')->insert([
                'user_id'    => $user_id,
                'username'   => $user->username,
                'full_name'  => $user->full_name,
                'role'       => $user->role,
                'title'      => $title,
                'description'=> $description,
                'type'       => $type,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
