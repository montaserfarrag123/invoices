<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $count_all =invoices::count();
        // $count_invoices1 = invoices::where('Value_Status', 1)->count();
        // $count_invoices2 = invoices::where('Value_Status', 2)->count();
        // $count_invoices3 = invoices::where('Value_Status', 3)->count();


        // $chartjs = app()->chartjs
        //  ->name('barChartTest')
        //  ->type('bar')
        //  ->size(['width' => 400, 'height' => 200])
        //  ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        //  ->datasets([
        //     [
        //         "label" => "الفواتير الغير المدفوعة",
        //         'backgroundColor' => ['#ec5858'],
        //         'data' => [60]
        //     ],
        //     [
        //         "label" => "الفواتير المدفوعة",
        //         'backgroundColor' => ['#81b214'],
        //         'data' => [80]
        //     ],
        //     [
        //         "label" => "الفواتير المدفوعة جزئيا",
        //         'backgroundColor' => ['#ff9642'],
        //         'data' => [90]
        //     ],
        //  ])
        //  ->options([]);

        $count_all =invoices::count();
        $count_invoices1 = invoices::where('Value_Status', 1)->count();
        $count_invoices2 = invoices::where('Value_Status', 2)->count();
        $count_invoices3 = invoices::where('Value_Status', 3)->count();

        if($count_invoices2 == 0){
            $nspainvoices2=0;
        }
        else{
            $nspainvoices2 = $count_invoices2/ $count_all*100;
        }

          if($count_invoices1 == 0){
              $nspainvoices1=0;
          }
          else{
              $nspainvoices1 = $count_invoices1/ $count_all*100;
          }

          if($count_invoices3 == 0){
              $nspainvoices3=0;
          }
          else{
              $nspainvoices3 = $count_invoices3/ $count_all*100;
          }


          $chartjs = app()->chartjs
              ->name('barChartTest')
              ->type('bar')
              ->size(['width' => 350, 'height' => 200])
              ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
              ->datasets([
                  [
                      "label" => "الفواتير الغير المدفوعة",
                      'backgroundColor' => ['#ec5858'],
                      'data' => [$nspainvoices2]
                  ],
                  [
                      "label" => "الفواتير المدفوعة",
                      'backgroundColor' => ['#81b214'],
                      'data' => [$nspainvoices1]
                  ],
                  [
                      "label" => "الفواتير المدفوعة جزئيا",
                      'backgroundColor' => ['#ff9642'],
                      'data' => [$nspainvoices3]
                  ],


              ])
              ->options([]);
        return view('home',compact('chartjs'));
    }
}
