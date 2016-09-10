<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Http\Controllers\Controller;


class GiftappController extends Controller
{
    

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    public function treeJson()
    {
        return file_get_contents(base_path() . '/public/data/giftapp.json');
    }

    public function index()
    {
        return view('giftDetails');
    }


}
