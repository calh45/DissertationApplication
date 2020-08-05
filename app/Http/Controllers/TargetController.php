<?php

namespace App\Http\Controllers;

use App\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Displays indepth view of a target
     * @param $targetId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($targetId) {
        $target = Target::find($targetId);

        return view("targetHome", ["target" => $target]);
    }
}
