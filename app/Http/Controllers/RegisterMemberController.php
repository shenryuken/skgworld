<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\VerifyEmail;

use App\Admin;
use App\User;
use App\Profile;
use App\Product;
use App\Package;
use App\Referral;
use App\Role;
use App\Sale;
use App\Wallet;
use App\Store;
use App\Stock;
use App\UserPurchase;
use App\UserBonus;
use App\Invoice;
use App\Rank;
use App\ActiveDo;
use App\ActiveSdo;
use App\Bank;

use Validator;
use Session;
use Carbon\Carbon;
use DB;
use Mail;


class RegisterMemberController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
}
