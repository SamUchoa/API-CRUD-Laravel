<?php


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(['name' => 'required', 'slug' => 'required', 'price' => 'required']);
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Product::findOrFail($id)->update($request->all());
        return Product::find($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(["deleted sucessfully"]);
    }

    public function search(Request $request)
    {
        $products = Product::where("name", "LIKE", "%" . $request->input("name") . "%")->get();
        if ($products->count() == 0) {
            return response()->json(["nenhum produto encontrado"], 404);
        }
        return response()->json(["resultados" => $products->count(), "produtos" => $products]);
    }
}
