<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Bonus;
use App\UserBonus;
use App\Order;
use App\Sale;
use App\Product;
use App\ProductSale;
use App\Wallet;

use Carbon\Carbon;

use DB;

class ReportController extends Controller
{
    public function members()
    {
        $reports = $this->getMembersReport();

        return view('reports.members.index', compact('reports'));
    }

    public function bonuses()
    {
    	$reports = $this->getBonusesReport();

        return view('reports.bonuses.index', compact('reports'));
    }

    public function sales()
    {
    	$reports = $this->getProductSalesReport();

        return view('reports.sales.index', compact('reports'));
    }

    public function salesByMonthYear($month, $year)
    {
        $reports = ProductSale::where('month', $month)->where('year', $year)->groupBy('product_id')->get();
        $reports2= ProductSale::where('month', $month)->where('year', $year - 1)->groupBy('product_id')->get();

        $report_merge = array_merge($reports->toArray(),$reports2->toArray());

        usort($report_merge, function ($item1, $item2) {
            return $item1['product_id'] <=> $item2['product_id'];
        });

        $graph_reports = array();
        $data = array();

        $cnt_array = count($report_merge);

        for($i=0; $i<$cnt_array; $i++){
            if($i < $cnt_array && $i+1 < $cnt_array)
            {
                if($report_merge[$i]['product_id'] == $report_merge[$i+1]['product_id'])
                {
                    $data = [
                         'y'             => Product::find($report_merge[$i]['product_id'] )->name,
                         $report_merge[$i]['year']   => $report_merge[$i]['quantity'],
                         $report_merge[$i+1]['year'] => $report_merge[$i+1]['quantity'],
                    ];

                    $graph_reports[] = $data;

                    $i++;
                } 
                else
                {
                    $data = [
                         'y'             => Product::find($report_merge[$i]['product_id'] )->name,
                         $report_merge[$i]['year']    => $report_merge[$i]['quantity'],
                         $report_merge[$i]['year']+1  => 0,
                    ];

                    $graph_reports[] = $data;
                }
            }
            
        }
        
        // foreach ($report_merge as $report) {


        //     $data = [
        //      'y'             => $report->product->
        //      'Year'          => $register->data,
        //     ];

        //     $stats_register[] = $data;
        // }
        //echo count($report_merge);
        // dump($graph_reports);
        // dump($report_merge);

        return view('reports.sales.by-month-year', compact('reports', 'month', 'year', 'graph_reports'));
    }

    public function stocks()
    {
    	$reports = $this->getStocksReport();

        list($reports1, $reports2) = array_chunk($reports, ceil(count($reports) / 2));

        return view('reports.stocks.index', compact('reports1', 'reports2'));
    }

    public function getMembersReport()
    {
        $date = Carbon::now();
        $startOfMOnth = Carbon::today()->startOfMonth();
        $endOfMonth   = Carbon::today()->endOfMonth();
        $startDate = Carbon::now()->startOfWeek()->format('Y/m/d');
        $endDate = $date = Carbon::now()->endOfWeek()->format('Y/m/d');

        $users                   = User::count();
        $customers               = User::where('rank_id',1)->count();
        $loyal_customer          = User::where('rank_id', 2)->count();
        $marketing_officer       = User::where('rank_id', 3)->count();
        $district_officer        = User::where('rank_id', 4)->count();
        $senior_district_officer = User::where('rank_id', 5)->count();
        $today                   = User::whereDate('created_at', $date )->count();
        $this_week               = User::whereBetween('created_at',[$startDate, $endDate])->count();
        $this_month              = User::whereMonth('created_at',Carbon::now()->format('n'))->count();
        // $monthly_register        = DB::table('users')->select(DB::raw('count(id) as `data`'),DB::raw("CONCAT_WS('-',MONTH(created_at),YEAR(created_at)) as monthyear"))
        //        ->groupBy('monthyear')
        //        ->get();
        $monthly_register        =  User::select(DB::raw('count(id) as `data`'), 
                                            DB::raw('MONTH(created_at) as `month`'),
                                            DB::raw('YEAR(created_at) as `year`'))
                                            ->groupBy('month','year')
                                            ->oldest()
                                            ->where('created_at', '>', $endOfMonth->subMonths(12))
                                            ->get();

        $stats_register = array();
        $data = array();

        foreach ($monthly_register as $register) {
            $data = [
             'y'             => $register->month.'-'.$register->year,
             'Registered'    => $register->data,
            ];

            $stats_register[] = $data;
        }

        $users = [
            'ALL'=> $users,
            'C'  => $customers,
            'LC' => $loyal_customer,
            'MO' => $marketing_officer,
            'DO' => $district_officer,
            'SDO'=> $senior_district_officer,
            'today' => $today,
            'this_week' => $this_week,
            'this_month' => $this_month,
            'monthly_register' => json_encode($stats_register)
        ];

        return $users;
    }

    public function getBonusesReport()
    {
        $date = Carbon::today();
        $this_year = $date->year;
        $this_month = $date->month;


        $last_month_bonus = UserBonus::whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('total_bonus');
        $monthly_total_bonus = UserBonus::select(DB::raw('sum(total_bonus) as `monthly_total_bonus`'),
                                          DB::raw('month as `month`'))
                                          ->groupBy('month')
                                          ->orderBy('month')
                                          ->where('year', $this_year)
                                          ->get();
        $stats_total_bonus = array();
        $data = array();

        foreach ($monthly_total_bonus as $total_bonus) {
            $data = [
             'y'             => date('F', mktime(0, 0, 0, $total_bonus->month, 10)),
             'Total Bonus'   => $total_bonus->monthly_total_bonus,
            ];

            $stats_total_bonus[] = $data;
        }
 
        $bonus = [
            'total_bonus'     => UserBonus::where('year', $this_year)->sum('total_bonus'),
            'retail_profit'   => UserBonus::where('year', $this_year)->sum('retail_profit'),
            'direct_sponsor'  => UserBonus::where('year', $this_year)->sum('direct_sponsor'),
            'personal_rebate' => UserBonus::where('year', $this_year)->sum('personal_rebate'),
            'do_group_bonus'  => UserBonus::where('year', $this_year)->sum('do_group_bonus'),
            'sdo_group_bonus' => UserBonus::where('year', $this_year)->sum('sdo_group_bonus'),
            'do_cto_pool'     => UserBonus::where('year', $this_year)->sum('do_cto_pool'),
            'sdo_cto_pool'    => UserBonus::where('year', $this_year)->sum('sdo_cto_pool'),
            'sdo_sdo'         => UserBonus::where('year', $this_year)->sum('sdo_sdo'),
            'monthly_total_bonus' => json_encode($stats_total_bonus),
        ];

        return $bonus;
    }

    public function getStocksReport()
    {
        $products = Product::all();

        $stats_products = array();
        $data = array();

        foreach ($products as $product) {
            $stocks = $product->stocks->where('status', 'Instock')->count();
            $data = [
                'y'      => $product->name,
                'Stocks' => $stocks,
            ];

            $stats_products[] = $data;
        }

        return $stats_products;
    }

    public function getProductSalesReport()
    {
        $products = Product::all();

        $this_year_sales = ProductSale::select(DB::raw('count(product_id) as `data`'),
                                          DB::raw('sum(quantity) as `quantity`'),
                                          DB::raw('sum(amount) as `amount`'),
                                          DB::raw('month as `month`'),
                                          DB::raw('year as `year`'))
                                        ->where('year', Carbon::today()->year)
                                        ->groupBy('month')
                                        ->orderBy('month')
                                        ->get();
        $last_year_sales = ProductSale::select(DB::raw('count(product_id) as `data`'),
                                        DB::raw('sum(quantity) as `quantity`'),
                                        DB::raw('sum(amount) as `amount`'),
                                        DB::raw('month as `month`'),
                                        DB::raw('year as `year`'))
                                        ->where('year', Carbon::today()->year - 1)
                                        ->groupBy('month')
                                        ->orderBy('month')
                                        ->get();

        $sales = [
            'this_year'  => $this_year_sales,
            'last_year' => $last_year_sales,
            'total_amount_this_year' => $this_year_sales->sum('amount'),
            'total_amount_last_year' => $last_year_sales->sum('amount'),
            'total_quantity_this_year' => $this_year_sales->sum('quantity'),
            'total_quantity_last_year' => $last_year_sales->sum('quantity'),
        ];

        return $sales;
    }

    public function getSalesReportByMonthYear($month,$year)
    {
        $reports = ProductSale::where('month', $month)->where('year', $year)->get();

        return $reports;
    }
}
