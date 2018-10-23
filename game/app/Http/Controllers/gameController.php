<?php

namespace App\Http\Controllers;

use App\Grid;
use App\Domain\gameService;
use Illuminate\Http\Request;

class gameController extends Controller
{
    public function __construct(gameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $success = $this->gameService->getAll();
        return $success;
    }

    public function store(Request $request)
    {
        $success = $this->gameService->createCell($request);
        return $success;
    }

    public function update(Request $request, $id)
    {
        $success = $this->gameService->updateCell($request, $id);
        return $success;
//        $grid = Grid::find($id);
//        $grid->x = $request->x;
//        $grid->y = $request->y;
//        $grid->data = $request->data;
//        $grid->save();
//        $success = '{}';
//        return $success;
    }

    public function show($id)
    {
        $grid = Grid::find($id);
        return $grid;
    }
}
