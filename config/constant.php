<?php
/**
 * Created by PhpStorm.
 * User: Akaradech
 * Date: 12/5/2558
 * Time: 11:39
 */
return [
    'available_sizes' => [
        'XS', 'S', 'M', 'L', 'XL', '2XL'
    ],
    'affiliate_cookie_expired' => 43200,
    'creator_rate'            => 10.00,
    'affiliate_rate'            => 15.00,
    'mubaza_email'            => env('SERVICE_EMAIL', 'service@mubaza.com'),
    'image_size' => [
        'profile' => [
            'min_file_size' => 0,
            'max_file_size' => 2097152,
            'max_width' => 64,
            'max_height' => 64,
            'min_width' => 0,
            'min_height' => 0,
        ],
        'shirt' => [
            'min_file_size' => 0,
            'max_file_size' => 2097152,
            'max_width' => 3000,
            'max_height' => 3000,
            'min_width' => 300,
            'min_height' => 300,
        ],
        'shirt_small' => [
            'min_file_size' => 0,
            'max_file_size' => 0,
            'max_width' => 280,
            'max_height' => 280,
            'min_width' => 0,
            'min_height' => 0,
        ],
        'shirt_medium' => [
            'min_file_size' => 0,
            'max_file_size' => 0,
            'max_width' => 550,
            'max_height' => 550,
            'min_width' => 0,
            'min_height' => 0,
        ],
        'shirt_large' => [
            'min_file_size' => 0,
            'max_file_size' => 0,
            'max_width' => 1100,
            'max_height' => 1100,
            'min_width' => 0,
            'min_height' => 0,
        ],
        'art' => [
            'min_file_size' => 0,
            'max_file_size' => 5242880,
            'max_width' => 2400,
            'max_height' => 3200,
            'min_width' => 2400,
            'min_height' => 3200,
        ],
    ],
    'profile_width'           => 500,
    'profile_height'          => 500,
    'allow_mime_type'         => [ 'image/jpg', 'image/jpeg', 'image/png', 'image/x-png' ],
    'provinces'               => [
        "กระบี่", "กรุงเทพมหานคร", "กาญจนบุรี", "กาฬสินธุ์",
        "กำแพงเพชร", "ขอนแก่น", "จันทบุรี", "ฉะเชิงเทรา", "ชลบุรี",
        "ชัยนาท", "ชัยภูมิ", "ชุมพร", "เชียงราย", "เชียงใหม่",
        "ตรัง", "ตราด", "ตาก", "นครนายก", "นครปฐม",
        "นครพนม", "นครราชสีมา", "นครศรีธรรมราช", "นครสวรรค์",
        "นนทบุรี", "นราธิวาส", "น่าน", "บุรีรัมย์", "บึงกาฬ", "ปทุมธานี",
        "ประจวบคีรีขันธ์", "ปราจีนบุรี", "ปัตตานี", "พระนครศรีอยุธยา", "พะเยา", "พังงา",
        "พัทลุง", "พิจิตร", "พิษณุโลก", "เพชรบุรี", "เพชรบูรณ์", "แพร่",
        "ภูเก็ต", "มหาสารคาม", "มุกดาหาร", "แม่ฮ่องสอน", "ยโสธร", "ยะลา",
        "ร้อยเอ็ด", "ระนอง", "ระยอง", "ราชบุรี", "ลพบุรี", "ลำปาง",
        "ลำพูน", "เลย", "ศรีสะเกษ", "สกลนคร", "สงขลา", "สตูล",
        "สมุทรปราการ", "สมุทรสงคราม", "สมุทรสาคร", "สระแก้ว", "สระบุรี", "สิงห์บุรี",
        "สุโขทัย", "สุพรรณบุรี", "สุราษฎร์ธานี", "สุรินทร์", "หนองคาย", "หนองบัวลำภู",
        "อ่างทอง", "อำนาจเจริญ", "อุดรธานี", "อุตรดิตถ์", "อุทัยธานี", "อุบลราชธานี"
    ],
    'admin_role'              => 'admin',
    'super_role'              => 'super',
    'user_role'               => 'user',
    'max_price'               => [
        'standard'   => 295,
        'thick'      => 349,
        'super_soft' => 450
    ],
    'transport_cost_free'     => 0,
    'transport_cost_register' => 20,
    'transport_cost_ems_a'    => 40,
    'transport_cost_ems_b'    => 50,
    'transport_cost_ems_c'    => 70,
    'transport_cost_ems_d'    => 90,
    'transport_cost_ems_e'    => 120,
    'url_prefix'              => 'เสื้อยืด',
    'youtube_campaign_url'    => 'https://www.youtube.com/watch?v=hcUS0DqW2UY',
    'youtube_campaign_embed'  => 'https://www.youtube.com/embed/hcUS0DqW2UY',
];