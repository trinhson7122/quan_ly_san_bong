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

//Home > Yêu cầu
Breadcrumbs::for('order', function ($trail) {
    $trail->parent('home');
    $trail->push('Yêu cầu');
});