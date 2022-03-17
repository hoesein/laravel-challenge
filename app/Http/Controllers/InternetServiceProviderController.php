<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use App\Http\Requests\MptInvAmountRequest;
use App\Services\InternetServiceProvider\Mpt;
use App\Services\InternetServiceProvider\Ooredoo;
use App\Services\InternetServiceProvider\IspOptions;
use Illuminate\Http\Response;

class InternetServiceProviderController extends Controller
{
    public function getMptInvoiceAmount(MptInvAmountRequest $request)
    {
        try {

            $mpt = new Mpt(new IspOptions($request->get('month'), Config::get('constants.MPT_MONTHLY_FEE')));

            return response()->json([
                'status' => 200,
                'data' => $mpt->diCalculateTotalAmount()
            ])
            ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);

        }catch (\Exception $e){

            return \response()->json([
                'status' => 500,
                'data' => $e->getMessage()
            ])
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

        }

    }
    
    public function getOoredooInvoiceAmount(Request $request)
    {
        try {

            $ooredoo = new Ooredoo(new IspOptions($request->get('month'), Config::get('constants.OOREDOO_MONTHLY_FEE')));

            return response()->json([
                'status' => 200,
                'data' => $ooredoo->diCalculateTotalAmount()
            ])
            ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);

        }catch (\Exception $e){

            return response()->json([
                'status' => 500,
                'msg' => $e->getMessage()
            ])
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

        }
    }
}
