<?php

namespace App\Http\Controllers;

use App\Models\shelf;
use Illuminate\Http\Request;
use PHPUnit\Runner\Exception;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = shelf::all();

            if (count($items) <= 0) {
                return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenemedi"]);
            } else {
                return response()->json(["data" => $items, "durum" => "Isilem basarili bir sekilde tamamlandi", "durumKodu" => "900"]);
            }

        } catch (\Throwable $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenirken bir hata olustu!", "hata" => $th->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $item = new shelf();
            $item->Name = $request->name;
            $item->Type = $request->type;
            $item->Comment = $request->comment;
            $item->Quantity = $request->quantity;
            $item->ShelfNumber = $request->number;
            $item->save();
            return response()->json(["durumKodu" => "600", "durum" => "Kayit basariyla eklendi"]);
        } catch (\Throwable $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit eklenirken bir hata olustu!", "hata" => $th->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $items = shelf::find($id);
            if ($items == null) {
                return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenemedi"]);
            } else {
                return response()->json(["data" => $items, "durum" => "Isilem basarili bir sekilde tamamlandi", "durumKodu" => "900"]);
            }

        } catch (Exception $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenirken bir hata olustu!", "hata" => $th->getMessage()]);
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            $item = shelf::find($id);
            $item->id =$request->id ;
            $request->name != null ? $item->Name = $request->name : null;
            $request->type != null ? $item->Type = $request->type : null;
            $request->comment != null ? $item->Comment = $request->comment : null;
            $request->quantity != null ? $item->Quantity = $request->quantity : null;
            $request->number != null ? $item->ShelfNumber = $request->number : null;
            $item->save();
            return response()->json(["itemId"=>$request->id,"durumKodu"=>900,"durum"=>"islem basarili","items"=>$request->name]);
        } catch (Exception $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit silinirken bir hata olustu!", "hata" => $th->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = shelf::destroy($id);
            if ($item == 0) {
                return response()->json(["durumKodu" => "300", "durum" => "Silme islemi basarisiz"]);
            } else {
                return response()->json(["durumKodu" => "300", "durum" => "Silme islemi basarili"]);
            }
        } catch (Exception $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit silinirken bir hata olustu!", "hata" => $th->getMessage()]);
        }
    }
}