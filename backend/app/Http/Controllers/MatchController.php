<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\MatchCreateRequest;
use App\Match;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Match as MatchResource;

class MatchController extends Controller
{

    public function index()
    {
        $matches = Match::paginate(5);

        return MatchResource::collection($matches);
    }


    public function store(Request $request, $game, $user)
    {
        $match = new Match;
        $match->team = $request->team;
        $match->game()->associate($game);
        $match->save();

        return new MatchResource($match);

    }

    public function storePlayer($game, $match, $user)
    {
        $match = Match::find($match);
        $user = User::find($user);
        if(!$match->hasPlayer($user->id)) {
            $match->addPlayer($user->id);
            $match->save();
            return response(null, 204);
        }
        return response(null,409);
    }

    public function show($game, Match $match)
    {
        return new MatchResource($match);
    }

    public function update(Request $request, Game $game, Match $match)
    {
        $match->team = $request->get('team', $match->team);
        $match->save();

        return new MatchResource($match);
    }

    public function destroy(Game $game, Match $match)
    {
        $match->delete();
        return response(null, 204);
    }
}
