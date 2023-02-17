<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lastcall;

class LastcallController extends Controller
{

    public function get() {
        return response()->json(Lastcall::get());
    }

    public function revoke() {
        return response()->json(Lastcall::revoke());
    }

}
