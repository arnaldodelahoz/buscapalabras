<?php

namespace App\Http\Controllers;
use App\Models\Word;
use Illuminate\Http\Request;
use Arr;
class WordController extends Controller
{
    public function search(Request $request, $letters, $num,$startWith){
        $searchParams = $request->all();
        $limit = Arr::get($searchParams, 'limit', 500);
        $num=is_int(intval($num))?$num:4;
        $exp = "^[" . strtolower(normalizer_normalize($letters)) . "]*$";
        $query = Word::where('word', 'regexp', $exp)->whereRaw('LENGTH(word) ='.$num);

        if($startWith && $startWith !== '--'){
            $query->where('word','like', $startWith.'%');
        }
        
        return $query->paginate($limit);
    }
}
