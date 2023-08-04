<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CustomerController extends Controller
{
    public  function test() {
        return "this is test";
    }

    public  function createCustomer(Request $request){
            if ($request->has('full_name') && $request->has('email') && $request->has('phone_number')) {
                $customer = new Customer();
                $customer->full_name = $request->full_name;
                $customer->email = $request->email;
                $customer->phone_number = $request->phone_number;

                $customer->save();

                return response()->json([

                    'message' => 'Customer created successfully',
                    'id'=> $customer->id
                ]);
            } else {
                return response()->json([
                    'message' => 'Please fill all the fields'
                ], 400);
            }




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


    public function updateCustomer($id) {

        $customer = Customer::find($id);

        if($customer == null) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $input = request()->only(['full_name', 'email', 'phone_number']);

        $validator = Validator::make($input, [
            'full_name' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone_number' => 'sometimes|required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        foreach ($input as $key => $value) {
            $customer->$key = $value;
        }

        try {
            $customer->save();
        } catch(\Exception $e) {
            return response()->json([
                'message' => 'Update error',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Customer updated successfully'
        ]);
    }

    public function  deleteCustomer($id) {
        $customer = Customer::find($id);

        if($customer == null) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        try {
            $customer->delete();
        } catch(\Exception $e) {
            return response()->json([
                'message' => 'Delete error',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }

    public  function getCustomer($id) {
        $customer = Customer::find($id);

        if($customer == null) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'customer' => $customer
        ]);

        return response()->json([
            'customer' => $customer
        ]);
    }
}
