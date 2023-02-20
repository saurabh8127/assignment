<?php

namespace App\Http\Controllers\Api\Board;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    protected $board;

    public function __construct(BoardRepository $board)
    {
        $this->board = $board;
    }

    public function show($id)
    {
        return response()->json([
            'data' => $this->board->show($id),
            'status' => true,
            'message' => 'Board fetched successfully.',
        ], 200);
    }

    //get data
    public function getData(Request $request)
    {
        $board_data = $this->board->getData();

        return response()->json([
            'data' => $board_data,
            'status' => true,
            'message' => 'Board fetched successfully.',
        ], 200);
    }

    //Create board
    public function create(Request $request)
    {
        //validate value
        $validated = Validator::make($request->all(), [
            'board_name' => 'required|string',
            'description' => 'required|string',
            'board_start_at' => 'date',
            'board_end_at' => 'date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => $validated->errors()->all(),
                'status' => false,
                'message' => 'Enter valid data.',
            ], 400);
        }

        $data = [
            'board_name' => $request->board_name,
            'board_end_at' => $request->board_end_at,
            'board_start_at' => $request->board_start_at,
            'board_description' => $request->description,
        ];

        //Create Board Repository
        $board_data = $this->board->addBoard($data);

        return response()->json([
            'data' => $board_data,
            'status' => true,
            'message' => 'Board added successfully.',
        ], 200);
    }

    //Delete board
    public function delete($id)
    {
        $response = $this->board->deleteBoard($id);

        return response()->json([
            'status' => $response,
            'message' => 'Data deleted.',
        ], 200);
    }

    //edit task
    public function edit(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'board_name' => 'required|string',
            'description' => 'required|string',
            'board_start_at' => 'date',
            'board_end_at' => 'date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => $validated->errors()->all(),
                'status' => false,
                'massage' => 'Enter valid value',
            ], 400);
        }

        $data = [
            'board_name' => $request->board_name,
            'board_description' => $request->description,
            'board_end_at' => $request->board_end_at,
            'board_start_at' => $request->board_start_at,
        ];

        //Edit Board Repository
        $board_data = $this->board->editBoard($data, $id);

        if (empty($board_data)) {
            return response()->json([
                'data' => '',
                'status' => true,
                'message' => 'Data not found.',
            ], 400);
        }

        return response()->json([
            'data' => $board_data,
            'status' => true,
            'message' => 'Data update successfully.',
        ], 200);
    }
}
