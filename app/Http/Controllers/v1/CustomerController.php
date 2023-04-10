<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public  function test() {
        return "this is test";
    }

    public  function createCustomer(Request $request){



        $customer = new Customer();
        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;

        $customer->save();

        return response()->json([
            'message' => 'Customer created successfully'
        ]);

    }

    public  function getAllCustomers(){
        $customers = Customer::all();

        if($customers->isEmpty())
            return response()->json([
                'message' => 'No customers found'
            ], 404);


        return response()->json([
            'customers' => $customers
        ]);
    }
}
