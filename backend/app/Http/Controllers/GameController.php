<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\GameCreateRequest;
use App\Http\Requests\GameUpdateRequest;
use App\Http\Requests\JoinGameRequest;
use App\Http\Resources\Game as GameResource;
use App\Match;
use App\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::latest()->take(5)->get();


        return GameResource::collection($games);
    }

    public function showMyGames(Request $request)
    {
        $user = $request->user();
        $games = $user->games()->get();

        return response(GameResource::collection($games), 200);
    }


    public function store(GameCreateRequest $request)
    {
        $game = new Game;
        $game->location = $request->location;
        $game->start_at = $request->start_at;
        $game->status = "ACTIVE";

        $game->save();

        return response(new GameResource($game), 201);
    }

    public function show(Game $game)
    {
        $this->complete($game);
        return new GameResource($game);
    }

    public function update(GameUpdateRequest $request, Game $game)
    {
        $game->location = $request->get('location', $game->location);
        $game->start_at = $request->get('start_at', $game->start_at);
        $game->status = $request->get('status', $game->status);

        $game->save();
        return new GameResource($game);

    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response(null, 204);
    }

    public function join(Request $request, Game $game)
    {
        if(!$game->hasUser($request->user()->id)) {
            $game->addUser([$request->user()->id]);
            return response("success", 204);
        }
            return response("failed", 409);
    }
    public function leave(Request $request, Game $game)
    {
        if($game->hasUser($request->user()->id)) {
            $game->removeUser([$request->user()->id]);
            $request->user()->deleteFromMatch([$request->user()->id]);
            return response(null, 204);
        }
        return response(null, 409);
    }

    public function complete(Game $game)
    {
        $now = date("Y-m-d H:i:s");
        $date = date("Y-m-d H:i:s", strtotime('+2 hour', strtotime($now)));

        if($date >= $game->start_at && $game->status != "COMPLETED") {
            $game->update(['status' => 'COMPLETED']);
            $users = $game->users()->get();
            foreach ($users as $user) {
                $user->addGamesPlayed();
                $user->changeBadge();
                $user->save();
            }
            $game->save();
        }
    }
}
