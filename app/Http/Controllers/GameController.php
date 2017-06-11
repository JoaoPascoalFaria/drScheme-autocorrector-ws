<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

class GameController extends Controller
{
    public function add( Request $request) {

        $name = $request->input("name");
        $xml = $request->input("gameXML");

        $game = new Game();
        $game->name = $name;
        $game->gameXML = $xml;
        $game->save();

        return response('Game added to database with id '.$game->id, 200)->header('Content-Type', 'text/plain');
    }

    public function addOrUpdate( Request $request) {

        $name = $request->input("name");
        $xml = $request->input("gameXML");

        // these allow game override in case of the same NAME is given
        $game = Game::where('name',"=",$name)->first();
        if( $game === null) {
            $game = new Game();
        }

        //$game = new Game();
        $game->name = $name;
        $game->gameXML = $xml;
        $game->save();

        return response('Game added to database with id '.$game->id, 200)->header('Content-Type', 'text/plain');
    }

    public function delete( Request $request) {

        $id = $request->input("id");

        Game::destroy($id);

        return response('Game deleted from database', 200)->header('Content-Type', 'text/plain');
    }


    public function update( Request $request) {

        $id = $request->input("id");
        $name = $request->input("name");
        $xml = $request->input("gameXML");

        $game = Game::find($id);
        if ($game === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__, 200)->header('Content-Type', 'text/plain');
        }

        $game->name = $name;
        $game->gameXML = $xml;
        $game->save();

        return response("Exam updated successfully", 200)->header('Content-Type', 'text/plain');
    }


    public function get( Request $request) {

        $id = $request->input("id");

        $game = Game::find($id);
        if ($game === null) {
            return response("Error at ".__FUNCTION__." in ".basename(__FILE__)." at line ".__LINE__, 200)->header('Content-Type', 'text/plain');
        }

        $json = array( "id"=>$game->id, "name"=>$game->name, "gameXML"=>$game->gameXML, "creationDate"=>$game->created_at );

        return response(json_encode($json))->header('Content-Type', 'multipart/form-data');
    }

    public function getAll() {

        $entries = Game::all();
        $games = array();
        foreach( $entries as $game ) {

            $game = array( "id"=>$game->id, "name"=>$game->name, "creationDate"=>$game->created_at );
            $games[] = $game;
        }

        return response(json_encode($games))->header('Content-Type', 'multipart/form-data');
    }
}
