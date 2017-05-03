<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        $solution = $request->input("solution");

        $exam_response = file_put_contents( "files/exams/".$name.".csv", $examb, LOCK_EX );
        $solution_response = file_put_contents( "files/exams/".$name.".scm", $solution, LOCK_EX );

        $exam = new Exam();
        $exam->name = $name;
        $exam->save();

        return response('Exam added to database', 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function delete( Request $request) {

        $id = $request->input("id");

        Exam::destroy($id);

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
        $solution = $request->input("solution");

        $exam = new Exam($id);
        $exam->name = $name;
        $exam->exam = $examb;
        $exam->solution = $solution;
        $exam->save();

        return response('Exam updated', 200)->header('Content-Type', 'text/plain');
    }


    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function get( Request $request) {

        $id = $request->input("id");

        $exam = new Exam($id);

        return response($exam)->header('Content-Type', 'text/plain');
    }


    /**
     * @param id
     * @param student
     * @param response
     * @return mixed
     */
    public function testExam( Request $request) {

        $id = $request->input("id");
        $student = $request->input("student");
        $content = $request->input("response");


        $exam = Exam::where('id', '=', $id);
        if ($exam === null) {
            return response("Error at testExam in ExamController.php line 95", 8192)->header('Content-Type', 'text/plain');
        }

        $content_response = file_put_contents( "files/tests/".$exam->name."_".$student.".scm", $content, LOCK_EX );

        $output = shell_exec('java -jar testExam.jar files/exams/'.$exam->name." files/tests/".$exam->name."_".$student.".scm single");

        return response($output, 8192)->header('Content-Type', 'text/plain');
    }
}