<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use App\Http\Requests\MptInvAmountRequest;
use App\Services\InternetServiceProvider\Mpt;
use App\Services\InternetServiceProvider\Ooredoo;
use App\Services\InternetServiceProvider\IspOptions;

class InternetServiceProviderController extends Controller
{
    public function getMptInvoiceAmount(MptInvAmountRequest $request)
    {
        $mpt = new Mpt(new IspOptions($request->get('month'), Config::get('constants.MPT_MONTHLY_FEE')));

        return response()->json([
            'data' => $mpt->diCalculateTotalAmount()
        ]);

    }
    
    public function getOoredooInvoiceAmount(Request $request)
    {
        $ooredoo = new Ooredoo(new IspOptions($request->get('month'), Config::get('constants.OOREDOO_MONTHLY_FEE')));
        
        return response()->json([
            'data' => $ooredoo->diCalculateTotalAmount()
        ]);
    }
}
