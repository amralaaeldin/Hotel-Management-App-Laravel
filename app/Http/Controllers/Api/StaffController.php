<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Models\User;

class StaffController extends Controller
{

    public function index()
    {
        $managers = User::with('creator')->select('id', 'name', 'national_id', 'email', 'avatar', 'created_by')->role('manager')->get();
        $receptionists = User::with('creator')->select('id', 'name', 'national_id', 'email', 'avatar', 'created_by')->role('receptionist')->get();

        return [
            "managers" => StaffResource::collection($managers),
            "receptionists" => StaffResource::collection($receptionists),
        ];
    }
}
