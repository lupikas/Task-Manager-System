<?php

namespace App\Http\Controllers;
use App\Task;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

//create task

  public function store(Request $request){

    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

      $data = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:4096',
        'type' => [
          'required',
          Rule::in(['basic', 'advanced', 'expert']),
          ],
        'status' => [
          'required',
          Rule::in(['todo', 'closed', 'hold']),
          ],
      ]);

      if($data->fails()){
        return response()->json($data->errors()->toJson(), 400);
      }

     $user = JWTAuth::parseToken()->authenticate();
     $userId = auth()->user()->id;

      $createTask = Task::create([
          'name' => $request->get('name'),
          'description' => $request->get('description'),
          'type' => $request->get('type'),
          'status' => $request->get('status'),
          'owner' => $userId,
          'user' => $request->get('user'),
      ]);

      $message = "Task created!";
      return response()->json(compact('message'),200);
  }

//show my tasks

  public function index(){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;
    $myTask = Task::Where('owner', $userId)->orWhere('user', $userId)->paginate(5);
    return response()->json(compact('myTask'),200);
  }

//update task

    public function update(Request $request, $task){
      if (! $user = JWTAuth::parseToken()->authenticate()) {
              return response()->json(['Please login or register!'], 404);
      }

      $data = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'description' => 'required|string|max:4096',
      'type' => [
        'required',
        Rule::in(['basic', 'advanced', 'expert']),
        ],
      'status' => [
        'required',
        Rule::in(['todo', 'closed', 'hold']),
        ],
  ]);

    if($data->fails()){
         return response()->json($data->errors()->toJson(), 400);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;

    $updateTask = Task::findOrFail($task);
    $taskOwnerId = $updateTask->owner;

    if($userId != $taskOwnerId){

      $message = "You can not update this task!";
      return response()->json(compact('message'),200);

    }
      else {

        $updateTask->name = $request->get('name');
        $updateTask->description = $request->get('description');
        $updateTask->type = $request->get('type');
        $updateTask->status = $request->get('status');
        $updateTask->user = $request->get('user');

          if($updateTask->status = $request->get('status') == "closed"){
              $state = 1;
              $updateTask->state = $state;
              $updateTask->save();
          }

    $message = "Task updated!";
    return response()->json(compact('message'),200);
    }
  }

//delete task

  public function delete(Request $request, $task){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;

    $deleteTask = Task::findOrFail($task);

    $taskOwnerId = $deleteTask->owner;

    if($userId != $taskOwnerId){

      $message = "You can not delete this task!";
      return response()->json(compact('message'),200);

    }
      else {

        $deleteTask ->delete();
        $message = "Task deleted!";
        return response()->json(compact('message'),200);
      }
  }

//view task $messages

  public function view(Request $request, $task){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;

    $task = Task::findOrFail($task);
    $taskId = $task -> id;
    $taskOwner = $task-> owner;
    $user = $task -> user;

    if($userId != $taskOwner and $userId != $user){

      $message = "You can not see the messages of this task!";
      return response()->json(compact('task', 'message'),200);

    }
      else {

        $taskMessage = Message::Where('taskId', $taskId)->paginate(5);
        return response()->json(compact('task', 'taskMessage'),200);
      }
  }
}
