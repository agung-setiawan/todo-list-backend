<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TodoList extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed'
    ];

    public static function getMyTodoList()
    {
        return TodoList::where('user_id', auth('sanctum')->user()->id)->get();
    }

    public static function CreateTodoList($data)
    {
        $data['user_id'] = auth('sanctum')->user()->id;
        return TodoList::create($data);
    }

    public static function Retrieve($id)
    {
        return TodoList::find($id);
    }
	
    public static function Updated($request)
    {
        $crud = TodoList::where('id', $request->id)
						->update([
							'title' 		=> $request->title,
							'description'	=> $request->description,
						]);
						
		return $crud;
    }
	
	public static function Remove($id)
	{
		$todo = TodoList::find($id);
		return $todo->delete();
	}	
}
