<?php
namespace App\Http\Controllers;
use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;
use DB;
class MatchingEngineController extends Controller
{
    public function matchingEngine(){
    	return view('matching_engine');
    }
}

?>