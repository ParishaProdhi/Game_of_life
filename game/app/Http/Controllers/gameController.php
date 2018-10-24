<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\gameService;
use App\Grid;

class gameController extends Controller
{
    public function __construct(gameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function store(Request $request)
    {
        try {
            $response = [];
            $response = $this->gameService->createGrid($request);
            $status = 201;
        } catch (\Exception $e) {
            $response = [];
            $status = 400;
//            $response['status'] = $status;
            $response['error'] = "Record Not Created";
        }
        return response()->json($response, $status);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->gameService->updateGrid($request, $id);
            $response = [];
            $status = 200;
            $response['data'] = [];
        } catch (\Exception $e) {
            $response = [];
            $status = 400;
//            $response['status'] = $status;
            $response['error'] = "Record Not Created";
        }
        return response()->json($response, $status);
    }

    public function show($id)
    {
        try {
            $grid = $this->gameService->findGrid($id);
            if (isset($_GET['after'])) {
                $requestedGenerations = $this->gameService->getGenerations($_GET['after'], $grid);
                $response = [];
                $status = 200;
//                $response['status'] = $status;
                $response['id'] = $grid->id;
                $response['x'] = $grid->x;
                $response['y'] = $grid->y;
                $response['data'] = $requestedGenerations;


            } else {

                if ($grid) {
                    $response = [];
                    $response = $grid;
                    $status = 200;
//                    $response['status'] = $status;
                } else {
                    $response = [];
                    $status = 404;
//                    $response['status'] = $status;
                    $response['error'] = "Not Found";
                }

            }

        } catch (\Exception $e) {
            $response = [];
            $status = 404;
//            $response['status'] = $status;
            $response['error'] = "Not Found";
        }
        return response()->json($response, $status);
    }

    public function list()
    {
        return $this->gameService->showAllGrids();
    }

}
