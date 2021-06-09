<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Processable;
use App\Models\User;
use App\Models\Run;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    
    public function dashboard()
    {
        $from = Carbon::now()->subDay();
        $to = Carbon::now();

        $runs = Run::whereBetween('runs.created_at', [$from, $to])
            ->join('processables', 'runs.processable_id', '=', 'processables.id')
            ->join('users', 'processables.user_id', '=', 'users.id');

        $mostActiveUser = $runs->select('users.name', DB::raw('COUNT(processables.user_id) as count'))
            ->groupBy('users.name')
            ->orderBy('count', 'desc')
            ->first()->name;

            $runs = Run::whereBetween('runs.created_at', [$from, $to])
            ->join('processables', 'runs.processable_id', '=', 'processables.id')
            ->join('users', 'processables.user_id', '=', 'users.id');

        $amountOfRoutes = $runs->where('processables.type_id', Processable::ROUTE)->get()->count();

        $runs = Run::whereBetween('runs.created_at', [$from, $to])
            ->join('processables', 'runs.processable_id', '=', 'processables.id')
            ->join('users', 'processables.user_id', '=', 'users.id');

        $amountOfTasks = $runs->where('processables.type_id', Processable::TASK)->get()->count();

        $runs = Run::whereBetween('runs.created_at', [$from, $to])
            ->join('processables', 'runs.processable_id', '=', 'processables.id')
            ->join('users', 'processables.user_id', '=', 'users.id');
        
        $mostActiveProcessable = $runs->select('processables.title', DB::raw('COUNT(runs.processable_id) as count'))
            ->groupBy('processables.title')
            ->orderBy('count', 'desc')
            ->first()->title;

        return view('dashboard', compact('mostActiveUser', 'amountOfRoutes', 'amountOfTasks', 'mostActiveProcessable'));
    }

    public function manage()
    {
        return view('manage');
    }
}
