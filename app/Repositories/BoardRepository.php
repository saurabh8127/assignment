<?php

namespace App\Repositories;

use App\Models\Board;
use App\Models\TaskBoardMapping;
use Illuminate\Support\Facades\DB;

class BoardRepository
{
    public function show($id)
    {
        $board = Board::where('id', $id)->first();

        $board_has_task = DB::Table('task_board_mappings')
            ->join('tasks', 'task_board_mappings.task_id', '=', 'tasks.id')
            ->where('task_board_mappings.board_id', $id)
            ->select([
                'tasks.*',
            ])->get();

        if (!$board) {
            return [];
        }

        $board->tasks = $board_has_task;

        return $board;
    }

    public function getData()
    {
        return Board::all();
    }

    public function addBoard($data)
    {
        $board_data = Board::create($data);

        return $board_data;
    }

    public function deleteBoard($id)
    {
        $board = Board::find($id);

        if (!$board) {
            return false;
        }

        TaskBoardMapping::where('board_id', $id)->delete();

        $board->delete();
        return true;
    }

    public function editBoard($data, $id)
    {
        $board_data = Board::where('id', $id)->first();

        if (!empty($board_data)) {
            $board_data->board_name = $data['board_name'];
            $board_data->board_end_at = $data['board_end_at'];
            $board_data->board_start_at = $data['board_start_at'];
            $board_data->board_description = $data['board_description'];

            $board_data->update();

            return $board_data;
        } else {
            return [];
        }
    }

    //check User Has Board
    public function checkUserHasBoard(int $boardId)
    {
        return Board::where([
            'created_by' => auth()->user()->id,
            'id' => $boardId,
        ])->first();
    }
}
