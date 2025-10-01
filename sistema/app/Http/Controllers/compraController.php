<?php

namespace App\Http\Controllers;
use App\Models\Compra;
use App\Models\Proveedore;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Http\Requests\StoreCompraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class compraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $compras = Compra::with('comprobante','proveedore.persona')
        ->where('estado',1)
        ->latest()
        ->get();
        // dd($compras);
        return view('compra.index',compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $proveedores = Proveedore::whereHas('persona',function($query){
            $query->where('estado',1);
        })->get();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado',1)->get();
        return view('compra.create',compact('proveedores','comprobantes','productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        //
        // dd($request->validated());

        try{
            DB::beginTransaction();
            //llenar tabla compras
            $compra = Compra::create($request->validated());
            //lenar tabla compra_producto
            //Recuprar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            //Realizar el llenado
            $sizeArray = count($arrayProducto_id);
            $cont= 0;            
            while($cont< $sizeArray){
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont]=>[
                        'cantidad'=>$arrayCantidad[$cont],
                        'precio_compra'=>$arrayPrecioCompra[$cont],
                        'precio_venta'=>$arrayPrecioVenta[$cont]
                    ]
                ]);
                //Actualizar el stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);

                DB::table('productos')
                ->where('id',$producto->id)
                ->update([
                    'stock'=>$stockActual + $stockNuevo
                ]);
                $cont++;
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('compras.index')->with('success','Compra exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        //
        // dd($compra->productos);

        return view('compra.show',compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Compra::where('id',$id)
        ->update([
            'estado'=>0
        ]);

        return redirect()->route('compras.index')->with('success','Compra eliminada');
    }
}
