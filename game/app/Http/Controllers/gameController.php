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
            $response['status'] = http_response_code();
        } catch (\Exception $e) {
            $response = [];
            $response['status'] = http_response_code();
            $response['error'] = "Record Not Created";
        }
        return json_encode($response);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->gameService->updateGrid($request, $id);
            $response = [];
            $response['status'] = http_response_code();
            $response['data'] = '{}';
        } catch (\Exception $e) {
            $response = [];
            $response['status'] = http_response_code();
            $response['error'] = "Record Not Created";
        }
        return json_encode($response);
    }

    public function show($id)
    {
        $grid = $this->gameService->findGrid($id);
        if (isset($_GET['after'])) {
            $requestedGenerations = $this->gameService->getGenerations($_GET['after'], $grid);
            $response = [];
            $response['status'] = http_response_code();
            $response['id'] = $grid->id;
            $response['x'] = $grid->x;
            $response['y'] = $grid->y;
            $response['data'] = $requestedGenerations;
            return $response;

        } else {

            if ($grid) {
                $response = [];
                $response = $grid;
                $response['status'] = http_response_code();
            } else {
                $response = [];
                $response['status'] = http_response_code();
                $response['error'] = "Record Not Created";
            }
            return json_encode($response);
        }

    }
}
