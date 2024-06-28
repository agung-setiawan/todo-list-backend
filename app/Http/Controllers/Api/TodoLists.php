<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/*
|   Call models
*/
use App\Models\TodoList as TL;

/*
|   Call helpers
*/
use Helper;

class TodoLists extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TL::getMyTodoList();
        $params = [
            'success' 	=> true,
            'message' 	=> 'Success',
            'data'    	=> TL::getMyTodoList()
        ];

        return Helper::ack($params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
        ]);

        if ($validator->fails()) 
		{
            return response()->json([
				'success' 	=> false,
				'message'	=> Helper::render_message($validator->errors())
			]);
        }

        $data = TL::CreateTodoList($request->all());

        $params = [
            'success' => true,
            'message' => 'Success',
            'data'    => $data
        ];

        return Helper::ack($params, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $params = [
            'success' 	=> true,
            'message' 	=> 'Success',
            'data'    	=> TL::Retrieve($id)
        ];
		
        return Helper::ack($params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
		$success = false;

        $validator = Validator::make($request->all(), [
			'id'	=> 'required',
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) 
		{
            return response()->json([
				'success' 	=> false,
				'message'	=> Helper::render_message($validator->errors())
			], 200);
        }
		
        $crud = TL::Updated($request);
		
		if ($crud)
		{
			$success = true;
		}
		
        $params = [
            'success' 	=> $success,
            'message' 	=> null,
            'data'    	=> null
        ];
		
        return Helper::ack($params);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
		$success = false;
		$responseCode = 500;

        $crud = TL::Remove($id);
		
		if ($crud)
		{
			$success = true;
			$responseCode = 200;
		}
		
        $params = [
            'success' 	=> $success,
            'message' 	=> null,
            'data'    	=> null
        ];
		
        return Helper::ack($params, $responseCode);
    }
}
