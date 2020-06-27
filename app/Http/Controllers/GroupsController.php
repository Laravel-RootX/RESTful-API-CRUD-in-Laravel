<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Validator;


class GroupsController extends Controller
{

    public function index()
    {
        $data['groups'] = Group::all();
        return view('groups.index', $data);
    }

}
