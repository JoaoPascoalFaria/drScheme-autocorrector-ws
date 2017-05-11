<?php

namespace App\Http\Controllers;

use App\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;


class EvaluationController extends Controller
{

    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function save( Request $request) {

        $user = $request->input("user");
        $exam = $request->input("exam");
        $grade = $request->input("grade");
        $data = $request->input("submission");

        //$evaluation = Evaluation::where('exam',"=",$exam)->where('user',"=",$user)->orderBy('created_at', 'desc')->first();

        $evaluation = new Evaluation();
        $evaluation->exam = $exam;
        $evaluation->user = $user;
        $evaluation->grade = $grade;
        $evaluation->submission = $data;

        $evaluation->save();

        return response('Evaluation of '.$evaluation->grade.' from user '.$evaluation->user.' added to database')->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function get( Request $request) {

        $user = $request->input("user");
        $exam = $request->input("exam");

        $evaluation = Evaluation::where('exam',"=",$exam)->where('user',"=",$user)->orderBy('created_at', 'desc')->first();
        if( $evaluation === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__.". No evaluations found", 200)->header('Content-Type', 'text/plain');
        }

        return response('Evaluation of '.$evaluation->grade.' from user '.$evaluation->user)->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function getSheet( Request $request) {

        $exam = $request->input("exam");

        $evaluation = Evaluation::where('exam',"=",$exam)->orderBy('created_at', 'desc')->groupBy('user')->get();
        if( $evaluation === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__.". No evaluations found", 200)->header('Content-Type', 'text/plain');
        }

        return response($evaluation)->header('Content-Type', 'text/plain');
    }

    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function getSheetPlus( Request $request) {

        $exam = $request->input("exam");


        $evaluation = DB::select(DB::raw("SELECT t1.* FROM evaluations t1 JOIN (SELECT user, MAX(grade) FROM evaluations GROUP BY user) t2 ON t1.user = t2.user AND t1.grade = t2.grade"));
        //$evaluation = Evaluation::where('exam',"=",$exam)->orderBy('grade', 'desc')->groupBy('user')->get();
        if( $evaluation === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__.". No evaluations found", 200)->header('Content-Type', 'text/plain');
        }

        return response($evaluation)->header('Content-Type', 'text/plain');
    }
}
