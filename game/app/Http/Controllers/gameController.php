<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\gameService;
use App\Grid;

class gameController extends Controller
{

    public function store(Request $request)
    {
        $x = $request->x;
        $y = $request->y;
        $data = $request->data;
        $gridArray = [[]];
        for ($i = 0; $i < $x; $i++) {
            for ($j = 0; $j < $y; $j++) {
                $gridArray[$i][$j] = $data[$i][$j];
            }
        }
        $success = Grid::create([
            'x' => $request->x,
            'y' => $request->y,
            'data' => json_encode($gridArray)
        ]);

        $response = [];
        if ($success) {
            $response = [];
            $response['x'] = $request->x;
            $response['y'] = $request->y;
            $response['data'] = $gridArray;
        } else {
            $response = [];
            $response['error'] = "Record Not Created";
        }
        return json_encode($response);

    }

    public function update(Request $request, $id){
        $grid = Grid::find($id);
        $grid->x = $request->x;
        $grid->y = $request->y;
        $data = $request->data;
        $gridArray = [[]];
        for ($i = 0; $i < $grid->x; $i++) {
            for ($j = 0; $j < $grid->y; $j++) {
                $gridArray[$i][$j] = $data[$i][$j];
            }
        }
        $grid->data = json_encode($gridArray);
        $grid->save();
        $success = '{}';
        return $success;
    }
}
