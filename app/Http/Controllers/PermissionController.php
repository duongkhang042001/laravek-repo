<?php

namespace App\Http\Controllers;

use App\Models\Core\Partner;
use App\Abstracts\Http\Controllers\ApiController;

class PermissionController extends ApiController
{
    public function index(string $partner)
    {
        $allPermissions = Partner::findOrFail($partner)->getAllPermissions();

        return $this->response->array([
            'success' => true,
            'data' => [
                [
                    'title' => 'Dashboard',
                    'enabled' => true,
                    'permissions' => [
                        [
                            'enabled' => true,
                            'name' => 'dashboard.index',
                            'title' => 'Dashboard',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ]
                    ]
                ],
                [
                    'title' => 'Quản lý tài khoản',
                    'enabled' => true,
                    'permissions' => [
                        [
                            'enabled' => true,
                            'name' => 'users.*',
                            'title' => 'Có quyền truy cập tất cả tài khoản, thêm, xoá, sửa',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                    ]
                ],
                [
                    'title' => 'Brandname',
                    'enabled' => true,
                    'permissions' => [
                        [
                            'enabled' => true,
                            'name' => 'campaigns.index',
                            'title' => 'Quản lý chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.store',
                            'title' => 'Tạo chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.update',
                            'title' => 'Cập nhật chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.destroy',
                            'title' => 'Xoá chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.approve',
                            'title' => 'Duyệt chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.import',
                            'title' => 'Import danh sách số điện thoại nhận tin nhắn chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'campaigns.cancel',
                            'title' => 'Huỷ chiến dịch',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'reports.index',
                            'title' => 'Truy cập báo cáo theo các chiến dịch Brandname',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'reports.export',
                            'title' => 'Xuất excel báo cáo theo các chiến dịch Brandname',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'messages.index',
                            'title' => 'Tra cứu tin nhắn đã gửi của các chiến dịch Brandname',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'messages.export',
                            'title' => 'Xuất excel báo cáo theo các chiến dịch Brandname',
                            'description' => 'Lorem ipsum dolor sit amet, vince adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                        ]
                    ]
                ],
                [
                    'title' => 'MO/MT',
                    'enabled' => true,
                    'permissions' => [
                        [
                            'enabled' => true,
                            'name' => 'mt_reports.index',
                            'title' => 'Truy cập báo cáo sản lượng tin nhắn MO - MT',
                            'description' => 'Truy cập báo cáo theo các chiến dịch Brandname theo ngày, tháng, ...'
                        ],
                        [
                            'enabled' => true,
                            'name' => 'mt_messages.index',
                            'title' => 'Truy cứu tin nhắn MO - MT',
                            'description' => 'Xuất excel báo cáo theo các chiến dịch Brandname theo ngày, tháng, ...'
                        ],
                    ]
                ]
            ]
        ]);
    }
}
