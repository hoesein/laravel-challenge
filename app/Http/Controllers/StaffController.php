<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaffController extends Controller
{
    protected $staff;
    
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }
    
    public function payroll()
    {
        $data = $this->staff->salary();
    
        return response()->json([
            'status' => 200,
            'data' => $data
        ])
        ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }
}
