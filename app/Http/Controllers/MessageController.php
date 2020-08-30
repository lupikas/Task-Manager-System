<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\Rule;
use App\Message;
use App\Task;
use App\Viewlog;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

  //create message

  public function createMessage(Request $request, $task){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $data = Validator::make($request->all(), [
    'subject' => 'required|string|max:255',
    'message' => 'required|string|max:4096',

    ]);

      if($data->fails()){
        return response()->json($data->errors()->toJson(), 400);
      }

  $user = JWTAuth::parseToken()->authenticate();
  $userId = auth()->user()->id;

  $taskId = Task::findOrFail($task);
  $taskOwner = $taskId -> owner;
  $user = $taskId -> user;

  if($userId != $taskOwner and $userId != $user ){

    $message = "You can not create a message for this task!";
    return response()->json(compact('message'),200);
  }
    else {

      $createMessage = Message::create([
        'subject' => $request->get('subject'),
        'message' => $request->get('message'),
        'owner' => $userId,
        'taskId' => $task,
        'user' => $user,
      ]);

      $message = "Message created!";
      return response()->json(compact('message'),200);
    }
  }

//update message

  public function updateMessage(Request $request, $task, $message){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $data = Validator::make($request->all(), [
      'subject' => 'required|string|max:255',
      'message' => 'required|string|max:4096',
    ]);

    if($data->fails()){
       return response()->json($data->errors()->toJson(), 400);
     }

  $user = JWTAuth::parseToken()->authenticate();
  $userId = auth()->user()->id;
  $taskId = Task::findOrFail($task);
  $taskOwner = $taskId -> owner;

  if($userId != $taskOwner){

    $message = "You can not update a message for this task!";
    return response()->json(compact('message'),200);
  }
    else {

      $updateMessage = Message::findOrFail($message);
      $updateMessage->subject = $request->get('subject');
      $updateMessage->message = $request->get('message');

      $updateMessage->save();

      $message = "Message updated!";
      return response()->json(compact('message'),200);
    }
  }

//delete messege

  public function deleteMessage(Request $request, $task, $message){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;
    $deleteMessage = Message::findOrFail($message);

    $messageOwnerId = $deleteMessage->owner;
    $messageTaskId = $deleteMessage->taskId;

    if($messageOwnerId != $userId or $messageTaskId != $task){

      $message = "You can not delete this message!";
      return response()->json(compact('message'),200);

    }
      else {

        $deleteMessage ->delete();
        $message = "Message deleted!";
        return response()->json(compact('message'),200);
      }
  }

//view message

  public function viewMessage(Request $request, $task, $message){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;

    $viewMessage = Message::findOrFail($message);
    $ownerId = $viewMessage->owner;
    $user = $viewMessage ->user;
    $taskId = $viewMessage ->taskId;

    if($userId != $ownerId and $userId != $user){

      $message = "You can not see this message!";
      return response()->json(compact('message'),200);

    }
      else {

        $createMessageLog = Viewlog::create([
          'userId' => $userId,
          'ownerId' => $user,
          'taskId' => $taskId,
        ]);
        return response()->json(compact('viewMessage'),200);
      }
  }

//view log

  public function viewMessageLog(){
    if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['Please login or register!'], 404);
    }

    $user = JWTAuth::parseToken()->authenticate();
    $userId = auth()->user()->id;

    $viewMessageLog = Viewlog::Where('userId', $userId)->orWhere('ownerId', $userId)->get();
    return response()->json(compact('viewMessageLog'),200);
  }

}
