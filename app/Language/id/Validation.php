<?php

// File: app/Language/id/Validation.php

return [
    // Default validation messages
    'required'             => 'Kolom {field} wajib diisi.',
    'min_length'           => 'Kolom {field} harus terdiri dari minimal {param} karakter.',
    'max_length'           => 'Kolom {field} tidak boleh lebih dari {param} karakter.',
    'exact_length'         => 'Kolom {field} harus terdiri dari {param} karakter.',
    'alpha'                => 'Kolom {field} hanya boleh berisi huruf.',
    'alpha_numeric'        => 'Kolom {field} hanya boleh berisi huruf dan angka.',
    'alpha_numeric_space'  => 'Kolom {field} hanya boleh berisi huruf, angka, dan spasi.',
    'alpha_dash'           => 'Kolom {field} hanya boleh berisi huruf, angka, garis bawah, dan strip.',
    'numeric'              => 'Kolom {field} hanya boleh berisi angka.',
    'integer'              => 'Kolom {field} harus berupa bilangan bulat.',
    'decimal'              => 'Kolom {field} harus berupa angka desimal.',
    'is_natural'           => 'Kolom {field} harus berupa angka positif.',
    'is_natural_no_zero'   => 'Kolom {field} harus berupa angka lebih besar dari nol.',
    'valid_email'          => 'Kolom {field} harus berupa alamat email yang valid.',
    'valid_emails'         => 'Kolom {field} harus berisi semua alamat email yang valid.',
    'valid_url'            => 'Kolom {field} harus berupa URL yang valid.',
    'valid_ip'             => 'Kolom {field} harus berisi IP yang valid.',
    'matches'              => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'differs'              => 'Kolom {field} harus berbeda dengan kolom {param}.',
    'is_unique'            => 'Kolom {field} sudah digunakan.',
    'in_list'              => 'Kolom {field} harus salah satu dari: {param}.',
    'not_in_list'          => 'Kolom {field} tidak boleh salah satu dari: {param}.',
    'regex_match'          => 'Kolom {field} tidak sesuai format.',
    'matches'              => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'permit_empty'         => 'Kolom {field} boleh dikosongkan.',
    'greater_than'         => 'Kolom {field} harus lebih besar dari {param}.',
    'greater_than_equal_to'=> 'Kolom {field} harus lebih besar atau sama dengan {param}.',
    'less_than'            => 'Kolom {field} harus kurang dari {param}.',
    'less_than_equal_to'   => 'Kolom {field} harus kurang atau sama dengan {param}.',
    'in_list'              => 'Kolom {field} harus salah satu dari: {param}.',

    // File upload
    'uploaded'             => 'Kolom {field} wajib diunggah.',
    'max_size'             => 'Ukuran file di kolom {field} terlalu besar.',
    'is_image'             => 'File di kolom {field} harus berupa gambar.',
    'mime_in'              => 'Kolom {field} harus berisi file dengan tipe: {param}.',
    'ext_in'               => 'Ekstensi file di kolom {field} harus salah satu dari: {param}.',
    'max_dims'             => 'Gambar di kolom {field} melebihi ukuran maksimum.',
];
