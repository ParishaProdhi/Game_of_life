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

        if ($success) {
            $response = [];
            $response['status'] = http_response_code();
            $response['id'] = $success->id;
            $response['x'] = $request->x;
            $response['y'] = $request->y;
            $response['data'] = $gridArray;
        } else {
            $response = [];
            $response['status'] = http_response_code();
            $response['error'] = "Record Not Created";
        }
        return json_encode($response);

    }

    public function update(Request $request, $id)
    {
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
        $response =[];
        $response['status'] = http_response_code();
        $response['data'] = '{}';
        return $response;
    }

    public function show($id)
    {
        $grid = Grid::find($id);
        if (isset($_GET['after'])) {
            $requestedGenerations = [];
            $generations = explode(',', $_GET['after']);
            foreach ($generations as $key=>$age){
                $x = $grid->x;
                $y = $grid->y;
                $data = json_decode($grid->data);
                $newGenGrid = [[]];
                $gen = $age;
                $k = 0;
                while ($k < $gen) {
                    for ($i = 0; $i < $x; $i++) {
                        for ($j = 0; $j < $y; $j++) {
                            $count = 0;
                            if ($i != 0 && $j != 0) {
                                if ($data[$i - 1][$j - 1] == 1) {
                                    $count++;
                                }
                            }
                            if ($i != 0) {
                                if ($data[$i - 1][$j] == 1) {
                                    $count++;
                                }
                            }
                            if ($i != 0 && $j != $y - 1) {
                                if ($data[$i - 1][$j + 1] == 1) {
                                    $count++;
                                }
                            }
                            if ($j != 0) {
                                if ($data[$i][$j - 1] == 1) {
                                    $count++;
                                }
                            }

                            if ($j != $y - 1) {
                                if ($data[$i][$j + 1] == 1) {
                                    $count++;
                                }
                            }

                            if ($i != $x - 1 && $j != 0) {
                                if ($data[$i + 1][$j - 1] == 1) {
                                    $count++;
                                }
                            }
                            if ($i != $x - 1) {
                                if ($data[$i + 1][$j] == 1 && ($i + 1) >= 0 && ($j) >= 0 && ($i + 1) < $x && ($j) < $y) {
                                    $count++;
                                }
                            }

                            if ($i != $x - 1 && $j != $y - 1) {
                                if ($data[$i + 1][$j + 1] == 1 && ($i + 1) >= 0 && ($j + 1) >= 0 && ($i + 1) < $x && ($j + 1) < $y) {
                                    $count++;

                                }
                            }

                            $newGenGrid[$i][$j] = ($count == 3) ? 1 : 0;
                            $count = 0;
                        }

                    }
                    for ($i = 0; $i < $x; $i++) {
                        for ($j = 0; $j < $y; $j++) {
                            $data[$i][$j] = $newGenGrid[$i][$j];
                        }
                    }
                    $k++;
                }
                $requestedGenerations[$key] = json_encode($newGenGrid);
            }
            $response = [];
            $response['status'] = http_response_code();
            $response['x'] = $grid->x;
            $response['y'] = $grid->y;
            $response['data'] = $requestedGenerations;
            return $response;

        } else {

            if ($grid) {
                $response = [];
                $response['status'] = http_response_code();
                $response['x'] = $grid->x;
                $response['y'] = $grid->y;
                $response['data'] = $grid->data;
            } else {
                $response = [];
                $response['status'] = http_response_code();
                $response['error'] = "Record Not Created";
            }
            return json_encode($response);
        }

    }
}
