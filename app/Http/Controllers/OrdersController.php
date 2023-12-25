<?php

namespace App\Http\Controllers;

use App\Models\Order;

use App\Models\Drug;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function createNewOrder(Request $request){
        $order=new Order();
        $order->drug_name=$request->drug_name;
        $order->amount=$request->amount;
        $order_name=$request->input('drug_name');
        $order_amount=$request->input('amount');
        $drug_orderd=Drug::where('commercial_name',$order_name)->first();
        if(!$drug_orderd){
            return response()->json([
                'The requested medication is not available'
            ]);
        }
        $drug_amount=$drug_orderd->amount;
        if($drug_amount<$order_amount){
            return response()->json([
                'There is not enough quantity'
            ]);
        }
        else{
            $order->save();
            return response()->json([
                'Added successfuly'=>$order
            ]);
        }
    }

    public function listAllOreders(){
        $orders=Order::all();
        return response()->json([
            'All Orders'=>$orders
        ]);
    }

    public function editOreder(Request $request){
        $id = $request->input('id');
        $order = Order::where('id', $id)->first();
        $oldStatus = $order->status; 
        $order->status = $request->input('status');
        $order->payment_status = $request->input('payment_status');
        $order_amount = $order->amount;
        $order->save();
        $drug_ordered = $order->drug_name;
        if($order->status == 'sent' && $oldStatus != 'sent')
        { 
            $drug = Drug::where('commercial_name', $drug_ordered)->first();
            $drug_amount = $drug->amount;
            $drug->amount = $drug_amount - $order_amount;
            $drug->save();
            $drugs=Drug::all();
            foreach($drugs as $drug){
                if($drug->amount==0){
                    $drug->delete();
                }
            }
        }
        return response()->json([
            "Edited successfully" => $order
        ]);
    }
}
