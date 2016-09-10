<?php
namespace App\Http\Controllers;

use Request;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Api;

use DB;
use Mail;
class ReportController extends Controller
{
    public function reportView(){
        session_start();
        if(!isset($_SESSION['userlevel'])){
            return view('login');
        }
        else{
            return view('reportsnew');
        }
    }
}