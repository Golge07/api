<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();

            if (count($users) <= 0) {
                return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenemedi"]);
            } else {
                return response()->json(["data" => $users, "durum" => "Isilem basarili bir sekilde tamamlandi", "durumKodu" => "900"]);
            }

        } catch (Exception $th) {
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
            $user = new User();
            $user->Name = $request->name;
            $user->Email = $request->email;
            $user->Password = $request->password;
            $user->Permission = $request->permission;
            $user->email_verified_at = false;
            $user->save();
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
            $users = User::find($id);
            if ($users == null) {
                return response()->json(["durumKodu" => "606", "durum" => "Kayit listelenemedi"]);
            } else {
                return response()->json(["data" => $users, "durum" => "Isilem basarili bir sekilde tamamlandi", "durumKodu" => "900"]);
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
            $user = User::findOrFail($id);
            $request->name != null ? $user->Name = $request->name : null;
            $request->email != null ? $user->Email = $request->email : null;
            $request->password != null ? $user->Password = $request->password : null;
            $request->permission != null ? $user->Permission = $request->permission : null;
            $user != null ? $user->save() : $user = "bir sıkıntı var";
            return response()->json($user);
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
            $user = User::destroy($id);
            if ($user == 0) {
                return response()->json(["durumKodu" => "300", "durum" => "Silme islemi basarisiz"]);
            } else {
                return response()->json(["durumKodu" => "900", "durum" => "Silme islemi basarili"]);
            }
        } catch (Exception $th) {
            return response()->json(["durumKodu" => "606", "durum" => "Kayit silinirken bir hata olustu!", "hata" => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkUser(Request $req)
    {
        try {
            $users = DB::select('select * from users where Email = :email and Password = :pas', ['email' => $req->email,'pas'=>$req->password]);
            
            if ($users == null) {
                return response()->json(["durumKodu" => "607", "durum" => "Kayit listelenemedi","a"=>$req]);
            } else {
                return response()->json(["durum" => "Isilem basarili bir sekilde listelendi", "durumKodu" => "900","data" => $users]);
            }

        } catch (Exception $th) {
            return response()->json(["durumKodu" => "606", "hata" => '$th->getMessage()',"durum" => "Kayit listelenirken bir hata olustu!"]);
        }
        
    }
}
