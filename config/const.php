<?php

return [
    // ランディングページの情報
    'landing_page' => [
        'url' => 'https://zotmansystem.com',
    ],
    'sms' => [
        // ショートメッセージのFROM名称
        'from_name' => 'CATTOBI',
    ],
    'project' => [
        // 案件タイプ
        'type' => [
            'erection'       => 0, // 架設
            'undisassembled' => 1, // 未解体
            'disassembled'   => 2, // 解体
        ],
        'type_name' => [
            'erection'       => '架設',
            'undisassembled' => '未解体',
            'disassembled'   => '解体',
        ],
        // 時間タイプ
        'time_type' => [
            'none'     => 0, // 特になし
            'am'       => 1, // AM
            'pm'       => 2, // PM
        ],
        'time_type_name' => [
            'none'     => '未定', // 特になし
            'am'       => 'AM',   // AM
            'pm'       => 'PM',   // PM
        ],
        'time_type_process_name' => [
            'none'     => '案件調整', // 特になし
            'am'       => 'AM',   // AM
            'pm'       => 'PM',   // PM
        ],
        // 道路
        'road' => [
            'none'  => 0,
            'short' => 1,
        ],
        'road_name' => [
            'none'  => '特になし',
            'short' => 'ショート現地',
        ],
    ],
    'charge' => [
        'edit_type' => [
            'edit' => 0, // 編集者
            'view' => 1, // 閲覧者
        ],
        'edit_type_str' => [
            'edit' => '編集者', // 編集者
            'view' => '閲覧者', // 閲覧者
        ],
    ],
    'sms' => [
        // ショートメッセージのタイプ
        'type' => [
            'survey'         => 0, // (ユーザー)現場調査報告時
            'advance_notice' => 1, // (ユーザー)前日連絡時
            'start'          => 2, // (クライアント)作業開始
            'fin'            => 3, // (クライアント)作業完了
            'charge_login'   => 4, // (担当者)ログイン情報送信
        ]
    ],
    // 管理者の種類
    'manager' => [
        'manager' => 0,
        'owner' => 1,
    ],
    // 広告会社の状態
    'advertisement' => [
        'status' => [
            'stop' => 0,
            'open' => 1,
        ],
    ],

];
