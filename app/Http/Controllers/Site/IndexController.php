<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function privacy()
    {
        return response()->json([
            'status'        =>      true,
            'message'       =>      "Privacy Policy Page"
        ]);
    }

    public function terms()
    {
        return response()->json([
            'status'        =>      true,
            'message'       =>      "Terms Page"
        ]);
    }
}
