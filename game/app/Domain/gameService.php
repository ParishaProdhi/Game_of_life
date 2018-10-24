<?php
/**
 * Created by PhpStorm.
 * User: prodhi
 * Date: 10/23/18
 * Time: 11:50 AM
 */

namespace App\Domain;
use App\Grid;


class gameService
{
    public function createGrid($request){
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
        return $success;

    }

    public function updateGrid($request, $id){
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

        return $grid;
    }
    public function findGrid($id){
        return Grid::find($id);
    }
    //TODO handle for 0 and negative generations
    //TODO optimize
    public function getGenerations($generation, $grid){
        $requestedGenerations = [];
        $newGenerationData = [];
        $generations = explode(',', $generation);
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
            $newGenerationData['age'] = trim($age);
            $newGenerationData['grid'] = json_encode($newGenGrid);
            $requestedGenerations[$key] = $newGenerationData;
        }

        return $requestedGenerations;
    }
    public function showAllGrids(){
        $grid = Grid::all();
        return $grid;
    }
}