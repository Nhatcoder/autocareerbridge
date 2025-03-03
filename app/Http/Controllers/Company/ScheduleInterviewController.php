<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleInterviewController extends Controller
{
    public function index(){
        return view('management.pages.company.schedule_interview.index');
    }
}
