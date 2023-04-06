<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

//admin breadcrumbs
//Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('admin.dashboard'));
});

//Home > Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('admin.dashboard'));
});

//Home > Loại sân
Breadcrumbs::for('pitchType', function ($trail) {
    $trail->parent('home');
    $trail->push('Loại sân', route('admin.pitchType'));
});

//Home > Sân bóng
Breadcrumbs::for('footballPitch', function ($trail) {
    $trail->parent('home');
    $trail->push('Sân bóng', route('admin.footballPitch'));
});

//Home > Thông tin sân bóng
Breadcrumbs::for('footballPitchDetail', function ($trail) {
    $trail->parent('footballPitch');
    $trail->push('Thông tin sân bóng');
});

//Home > Yêu cầu lịch
Breadcrumbs::for('orderCalendar', function ($trail) {
    $trail->parent('home');
    $trail->push('Yêu cầu lịch', route('admin.orderCalendar'));
});
//Home > Yêu cầu bảng
Breadcrumbs::for('orderTable', function ($trail) {
    $trail->parent('home');
    $trail->push('Yêu cầu bảng');
});
//Home > Yêu cầu lịch > thanh toán
Breadcrumbs::for('orderCheckout', function ($trail) {
    $trail->parent('orderCalendar');
    $trail->push('Thanh toán');
});