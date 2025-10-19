<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah surat masuk
        $incomingCount = IncomingMail::count();
        
        // Menghitung jumlah surat keluar
        $outgoingCount = OutgoingMail::count();
        
        // Menghitung total seluruh surat
        $totalCount = $incomingCount + $outgoingCount;
        
        return view('pages.dashboard.index', compact('totalCount', 'incomingCount', 'outgoingCount'));
    }
}