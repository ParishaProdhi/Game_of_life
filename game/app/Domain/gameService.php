<?php

/**
 * Created by PhpStorm.
 * User: prodhi
 * Date: 10/22/18
 * Time: 4:53 PM
 */

namespace App\Domain;

use App\Grid;
use Illuminate\Http\Request;

class gameService
{
    public function getAll()
    {
        $all = Grid::all();
        return json_encode($all);
    }

    public function createCell(Request $request)
    {
        $success = Grid::create([
            'id' => $request->id,
            'x' => $request->x,
            'y' => $request->y,
            'data' => $request->data
        ]);
        if ($success) {
            $response = [];
            $response['id'] = $request->id;
            $response['x'] = $request->x;
            $response['y'] = $request->y;
            $response['data'] = $request->data;
        } else {
            $response = [];
            $response['error'] = "Record Not Created";
        }
        return json_encode($response);
    }

    public function updateCell(Request $request, $id)
    {
        $grid = Grid::find($id);
        $grid->x = $request->x;
        $grid->y = $request->y;
        $grid->data = $request->data;
        $grid->save();
        $success = '{}';
        return $success;

    }
}
