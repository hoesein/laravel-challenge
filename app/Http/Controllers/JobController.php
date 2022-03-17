<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Applicant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobController extends Controller
{
    protected $applicant;
    
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }
    
    public function apply(Request $request)
    {
        $data = $this->applicant->applyJob();
        
        return response()->json([
            'status' => 200,
            'data' => $data
        ])
        ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }
}
