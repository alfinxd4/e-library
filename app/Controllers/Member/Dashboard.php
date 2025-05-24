<?php

namespace App\Controllers\Member;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    public function index() {
        return view('member/dashboard');
    }
}
?>