<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\GameCreateRequest;
use App\Http\Requests\GameUpdateRequest;
use App\Http\Resources\Game as GameResource;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::paginate(5);

        return GameResource::collection($games);
    }


    public function store(GameCreateRequest $request)
    {
        $game = new Game;
        $game->location = $request->location;
        $game->start_at = $request->start_at;
        $game->status = "ACTIVE";

        $game->save();

        return new GameResource($game);
    }

    public function show(Game $game)
    {
        return new GameResource($game);
    }

    public function update(GameUpdateRequest $request, Game $game)
    {
        //$this->authorize('update', $game);
        $game->location = $request->get('location', $game->location);
        $game->start_at = $request->get('start_at', $game->start_at);
        $game->status = $request->get('status', $game->status);

        $game->save();
        return new GameResource($game);

    }

    public function destroy(Game $game)
    {
        //$this->authorize('destroy', $game);
        $game->delete();
        return response(null, 204);
    }
}
