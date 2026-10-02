<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Chat\Conversations;
use App\Models\Chat\Messages;


class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conversations = Conversations::where('user1_id', Auth::user()->id)
            ->orWhere('user2_id', Auth::user()->id)
            ->get();
        $user = Auth::user();
        $users = User::where('id', '!=', $user->id)->get();
        return view('chat.index', compact('user', 'users', 'conversations'));
    }

    public function conversation($id)
    {
        $user = Auth::user();
        $users = User::where('id', '!=', $user->id)->get();
        $conversation = Conversations::findOrFail($id);
        if ($conversation->user1_id != $user->id && $conversation->user2_id != $user->id) {
            return redirect()->route('chat.index')->with('warning', 'No puedes acceder a esta conversación');
        }

        // my_avatar
        if ($user->avatar) {
            $my_avatar = $user->avatar;
        } else {
            $my_avatar = 'no';
        }

        $conversations = Conversations::where('user1_id', Auth::user()->id)
            ->orWhere('user2_id', Auth::user()->id)
            ->get();

        $to_user = User::where('id', '!=', $user->id)
        ->where(function ($query) use ($conversation) {
            $query->where('id', $conversation->user1_id)
                ->orWhere('id', $conversation->user2_id);
        })
        ->first();

        // reciver_avatar
        if ($to_user->avatar) {
            $reciver_avatar = $to_user->avatar;
        } else {
            $reciver_avatar = 'no';
        }

        $messages = Messages::where('conversations_id', $conversation->id)->orderBy('created_at', 'DESC')->get();
        
        return view('chat.chat_usuario', compact('user', 'to_user', 'users', 'conversation', 'conversations', 'messages', 'my_avatar', 'reciver_avatar'));
    }

    public function createChat(Request $request)
    {
        $user = Auth::user();
        $to_user = User::findOrFail($request->user_select);
        $conversation_name = $user->name . ' - ' . $to_user->name;
        if ($request->chat_name) {
            $conversation_name = $request->chat_name;
        }
        $conversations = Conversations::where('user1_id', $user->id)
            ->where('user2_id', $to_user->id)
            ->orWhere('user1_id', $to_user->id)
            ->where('user2_id', $user->id)
            ->where('id_status_delete', 1)
            ->first();
        if ($conversations) {
            return redirect()->route('chat.to_user', $conversations->id)->with('warning', 'Ya existe una conversación con este usuario');
        } else {
            $conversations = new Conversations();
            $conversations->user1_id = $user->id;
            $conversations->user2_id = $to_user->id;
            $conversations->name = $conversation_name;
            $conversations->created_at = Carbon::now();
            $conversations->updated_at = Carbon::now();
            $conversations->id_status_delete = 1;
            $conversations->save();
            return redirect()->route('chat.to_user', $conversations->id)->with('success', 'Se ha creado una nueva conversación');
    }
}

    public function sendMessage(Request $request){
        $user = Auth::user();
        $conversation = Conversations::findOrFail($request->conversation_id);
        $message = new Messages();
        $message->conversations_id = $conversation->id;
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->created_at = Carbon::now();
        $message->updated_at = Carbon::now();
        $message->id_status_delete = 1;
        $message->save();

        // Response to ajax js
        $response = array(
            'status' => 'success',
            'message' => $message->message,
        );

        return response()->json($response);
    }

}