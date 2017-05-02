<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function add() {

        $name = Input::get("name");
        $examb = Input::get("exam");
        $solution = Input::get("solution");

        $exam = new Exam();
        $exam->name = $name;
        $exam->exam = $examb;
        $exam->solution = $solution;
        $exam->save();
        return response('Exam added to database', 200)->header('Content-Type', 'text/plain');
    }


}