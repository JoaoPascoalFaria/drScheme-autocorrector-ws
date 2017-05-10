<?php

namespace App\Http\Controllers;

use App\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


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
        $data = $request->input("data");

        $evaluation = Evaluation::where('exam',$exam)->where('user',$user)->first();
        if ($exam === null) {
            $evaluation = new Evaluation();
        }

        $evaluation->exam = $exam;
        $evaluation->user = $user;
        $evaluation->grade = $grade;
        $evaluation->submission = $data;
        $evaluation->save();

        return response('Evaluation added to database')->header('Content-Type', 'text/plain');
    }

    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     *//*
    public function delete( Request $request) {

        $id = $request->input("id");

        Exam::destroy($id);

        return response('Exam deleted from database', 200)->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     *//*
    public function update( Request $request) {

        $id = $request->input("id");
        $name = $request->input("name");
        $examb = $request->input("exam");
        $solution = $request->input("solution");

        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at testExam in ExamController.php line 95", 200)->header('Content-Type', 'text/plain');
        }

        $response = "Exam updated.";

        $exam->name = $name;
        $newEHash = hash("md5",$examb);
        $newSHash = hash("md5",$solution);
        if( $exam->examHash != $newEHash ) {

            $response .= " Updated exam.";
            $exam->examHash = $newEHash;
            $exam_response = file_put_contents( "files/exams/".$id.".csv", $examb, LOCK_EX );
        }
        if( $exam->solutionHash != $newSHash ) {

            $response .= " Updated solution.";
            $exam->solutionHash = $newSHash;
            $solution_response = file_put_contents( "files/exams/".$id.".scm", $solution, LOCK_EX );
        }
        $exam->save();

        return response($response, 200)->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     *//*
    public function get( Request $request) {

        $id = $request->input("id");

        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at testExam in ExamController.php line 95", 200)->header('Content-Type', 'text/plain');
        }

        $json = array( "id"=>$exam->id, "name"=>$exam->name, "exam"=>file_get_contents('files/exams/'.$exam->id.'.csv') ,"solution"=>file_get_contents('files/exams/'.$exam->id.'.scm') );


        return response(json_encode($json))->header('Content-Type', 'text/plain');
    }/**/
}
