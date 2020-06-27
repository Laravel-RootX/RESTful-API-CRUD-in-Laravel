<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Create Value
    public function create(Request $request, $name, $mobile_num)
    {
        $groups = new Group();
        $groups->name = $name;
        $groups->mobile_num = $mobile_num;
        $groups->save();
        return response()->json($groups);
    }

    // Read Values
    public function show()
    {
        $groups = Group::all();
        return response()->json($groups);
    }

    // Read Single Value
    public function showbyId($id)
    {
        $groups = Group::find($id);
        return response()->json($groups);
    }

    // Update Value
    public function update(Request $request, $id, $name, $mobile_num)
    {
        $groups = Group::find($id);
        // $groups->name = $request->input('name');
        $groups->name = $name;
        //  $groups->mobile_num = $request->input('mobile_num');
        $groups->mobile_num = $mobile_num;
        $groups->save();
        return response()->json($groups);
    }

    // Delete Value
    public function deletebyId(Request $request, $id)
    {
        $groups = Group::find($id);
        $groups->delete();
        return response()->json($groups);
    }
}
