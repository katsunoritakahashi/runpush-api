<?php

use App\Enums\InquiryStatus;

return [
    InquiryStatus::class => [
        InquiryStatus::Waiting => '未対応',
        InquiryStatus::InProgress => '対応中',
        InquiryStatus::Completed => '対応済み',
    ],
];
