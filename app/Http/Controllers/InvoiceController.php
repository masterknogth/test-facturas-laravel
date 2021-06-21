<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\ProductInvoice;

use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{   
    
    //GENERO FACTURA
    public function generateInvoice(Request $request)
    {   
        date_default_timezone_set('America/Caracas');
         
        
       
        $rules = [
          'buyer_name' => 'required|string|max:100', 
          'buyer_nit' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['created' => false, 'error'=>$validator->errors()],422);
        }
        
        $permitted_chars = '0123456789'; 
        $invoiceNumber = substr(str_shuffle($permitted_chars),0, 8);
        
        

        $invoice = new Invoice();
        $invoice->number = $invoiceNumber;
        $invoice->seller_name = $user = Auth::user()->name;
        $invoice->seller_nit =  $user = Auth::user()->nit;
        $invoice->buyer_name = $request->input('buyer_name');
        $invoice->buyer_nit = $request->input('buyer_nit');
        $invoice->date = date("d/m/Y");
        $invoice->hour = date("H:i");
        $invoice->save();      

        //obtento el id de la factura que acabo de registrar para insertarla en la tabla
        //de product_invoices
        $invoiceCreated = Invoice::latest('id')->first();
        
        //obtengo los item que provienen de un json el frontend
        $items = json_decode($request->input('items'), true );
        
        foreach ($items as $value) {
            $valuesAux = [];
            $valuesAux['invoice_id'] = $invoiceCreated->id;
            $valuesAux['description'] = $value['description'];
            $valuesAux['quantity'] = $value['quantity'];
            $valuesAux['value'] = $value['value'];
            $valuesAux['total_value'] = ($value['value'] * $value['quantity']);
            $valuesAux['created_at'] = date('Y-m-d H:m:s');
            $valuesAux['updated_at'] = date('Y-m-d H:m:s');
            $values[] = $valuesAux;
           
        }

         
        ProductInvoice::insert($values);

        return response()->json(['message'=>'Factura generada'],200);
    }

    //EDITO FACTURA
    public function update(Request $request, $id)
    {   
        date_default_timezone_set('America/Caracas');

        $invoice = Invoice::find($id);
        $rules = [
          'number' => 'required|integer|unique:invoices,number,'.$invoice->id, 
          'seller_name' => 'required|string|max:255',
          'seller_nit' => 'required', 
          'buyer_name' => 'required|string|max:255',
          'buyer_nit' => 'required', 
          'date' => 'required',  
          'hour' => 'required',        
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['created' => false, 'error'=>$validator->errors()],422);
        }

        Invoice::where('id',$id)-> update([
            'number' => $request->input('number'),
            'seller_name' => $request->input('seller_name'),
            'seller_nit' => $request->input('seller_nit'),
            'buyer_name' => $request->input('buyer_name'),
            'buyer_nit' => $request->input('buyer_nit'),
            'date' => $request->input('date'),
            'hour' => $request->input('hour'),

        ]);

        return response()->json(['message'=>'Factura editada'],200); 

    }


    // LISTAR TODAS LAS FACTURAS

    public function allInvoices()
    {   
         
        $invoices = Invoice::all();
    
        for($i = 0; $i < sizeof($invoices); $i++)
        {   
            $invoices[$i]->items;                 
            $array[] = $invoices[$i];
         
        }
        if(sizeof($invoices) == 0)
        {
            return response()->json(['message'=>"No hay facturas"],404);
        }else{
            return response()->json(['invoices'=>$array],200);
        }

    }

    //MOSTRAR UNA FACTURA EN ESPECIFICO

    public function invoiceById($id)
    {
        $invoice =  Invoice::find($id);
        
        if(!$invoice){
            return response()->json(['error'=>'Esta factura no se encuentra'],404);
        }else{
            $invoice->items;
            return response()->json(['invoice'=>$invoice],200);
        }
       
    }
} 
