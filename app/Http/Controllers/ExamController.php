<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

class ExamController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function add( Request $request) {

        $name = $request->input("name");
        $examb = $request->input("exam");
        $wording = $request->input("wording");
        $solution = $request->input("solution");
        $timelimit = $request->input("timelimit");

        $exam = new Exam();
        $exam->name = $name;
        $exam->examHash = hash( "md5", $examb);
        $exam->wordingHash = hash( "md5", $wording);
        $exam->solutionHash = hash( "md5", $solution);
        $exam->timeLimit = $timelimit;
        $exam->save();

        $exam_response = file_put_contents( "files/exams/".$exam->id.".csv", $examb, LOCK_EX );
        $wording_response = file_put_contents( "files/exams/".$exam->id.".json", $wording, LOCK_EX );
        $solution_response = file_put_contents( "files/exams/".$exam->id.".scm", $solution, LOCK_EX );

        return response('Exam added to database with id '.$exam->id, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function delete( Request $request) {

        $id = $request->input("id");

        Exam::destroy($id);

        //TODO delete all files related to exam?

        return response('Exam deleted from database', 200)->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function update( Request $request) {

        $id = $request->input("id");
        $name = $request->input("name");
        $examb = $request->input("exam");
        $wording = $request->input("wording");
        $solution = $request->input("solution");
        $timelimit = $request->input("timelimit");

        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__, 200)->header('Content-Type', 'text/plain');
        }

        $response = "Exam updated.";

        $exam->name = $name;
        $exam->timeLimit = $timelimit;
        $newEHash = hash("md5", $examb);
        $newWHash = hash("md5", $wording);
        $newSHash = hash("md5", $solution);
        if( $exam->examHash != $newEHash ) {

            $response .= " Updated exam.";
            $exam->examHash = $newEHash;
            $exam_response = file_put_contents( "files/exams/".$id.".csv", $examb, LOCK_EX );
        }
        if( $exam->wordingHash != $newWHash ) {

            $response .= " Updated wording.";
            $exam->wordingHash = $newWHash;
            $wording_response = file_put_contents( "files/exams/".$id.".json", $wording, LOCK_EX );
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
     */
    public function get( Request $request) {

        $id = $request->input("id");

        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__, 200)->header('Content-Type', 'text/plain');
        }

        $json = array( "id"=>$exam->id, "name"=>$exam->name, "timelimit"=>$exam->timeLimit, "exam"=>file_get_contents('files/exams/'.$exam->id.'.csv'), "wording"=>file_get_contents('files/exams/'.$exam->id.'.json'), "solution"=>file_get_contents('files/exams/'.$exam->id.'.scm') );


        return response(json_encode($json))->header('Content-Type', 'multipart/form-data');
    }


    /**
     * @param id
     * @param student
     * @param response
     * @return mixed
     */
    public function reviewExam( Request $request) {

        $id = $request->input("id");
        $student = str_replace(" ","_",strtolower($request->input("student")));
        $content = $request->input("response");


        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__, 200)->header('Content-Type', 'text/plain');
        }
        /*
        $content_response = file_put_contents( "files/tests/".$exam->id."_".$student.".scm", $content, LOCK_EX );
        $output = shell_exec('java -jar java/testExam.jar files/exams/'.$exam->id." files/tests/".$exam->id."_".$student.".scm single");
        */
        $content_response = file_put_contents( "files/tests/".$id."_".$student.".scm", $content, LOCK_EX );
        $output = shell_exec('java -jar java/testExam.jar files/exams/'.$id." files/tests/".$id."_".$student.".scm review");

        return response($output)->header('Content-Type', 'multipart/form-data');
    }

    /**
     * @return mixed
     */
    public function listExams() {

        $entries = Exam::all();
        $exams = array();
        foreach( $entries as $exam ) {

            $exam = array( "id"=>$exam->id, "name"=>$exam->name);
            $exams[] = $exam;
        }

        return response(json_encode($exams))->header('Content-Type', 'multipart/form-data');
    }

    /**
     * @param id
     * @param student
     * @param response
     * @return mixed
     */
    public function evaluateExam( Request $request) {

        $id = $request->input("id");
        $student = str_replace(" ","_",strtolower($request->input("student")));
        $content = $request->input("response");


        $exam = Exam::find($id);
        if ($exam === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__.". Exam not found", 200)->header('Content-Type', 'text/plain');
        }

        /*
        $content_response = file_put_contents( "files/tests/".$exam->id."_".$student.".scm", $content, LOCK_EX );
        $output = shell_exec('java -jar java/testExam.jar files/exams/'.$exam->id." files/tests/".$exam->id."_".$student.".scm single");
        */
        $content_response = file_put_contents( "files/tests/".$id."_".$student.".scm", $content, LOCK_EX );
        $output = shell_exec('java -jar testExam.jar files/exams/'.$id." files/tests/".$id."_".$student.".scm evaluate");

        return response($output)->header('Content-Type', 'multipart/form-data');
    }
}