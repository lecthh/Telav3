<?php

namespace App\Http\Controllers\vendor\Chatify\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class MessagesController extends Controller
{
    protected $perPage = 30;

     /**
     * Authinticate the connection for pusher
     *
     * @param Request $request
     * @return void
     */
    public function pusherAuth(Request $request)
    {
        return Chatify::pusherAuth(
            $request->user(),
            Auth::user(),
            $request['channel_name'],
            $request['socket_id']
        );
    }

    /**
     * Fetch data by id for (user/group)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function idFetchData(Request $request)
    {
        return Auth::user();
        // Favorite
        $favorite = Chatify::inFavorite($request['user_id']);

        // User data
        if ($request['type'] == 'user') {
            $fetch = User::where('user_id', $request['user_id'])->first();
            if($fetch){
                $userAvatar = Chatify::getUserWithAvatar($fetch)->avatar;
            }
        }

        // send the response
        return Response::json([
            'favorite' => $favorite,
            'fetch' => $fetch ?? null,
            'user_avatar' => $userAvatar ?? null,
        ]);
    }

    /**
     * This method to make a links for the attachments
     * to be downloadable.
     *
     * @param string $fileName
     * @return \Illuminate\Http\JsonResponse
     */
    public function download($fileName)
    {
        $path = config('chatify.attachments.folder') . '/' . $fileName;
        if (Chatify::storage()->exists($path)) {
            return response()->json([
                'file_name' => $fileName,
                'download_path' => Chatify::storage()->url($path)
            ], 200);
        } else {
            return response()->json([
                'message'=>"Sorry, File does not exist in our server or may have been deleted!"
            ], 404);
        }
    }

    /**
     * Send a message to database
     *
     * @param Request $request
     * @return JSON response
     */
    public function send(Request $request)
    {
        try {
            // Get user info
            $user = Auth::user();
            
            // Validate request
            if (!$request->has('message') && !$request->has('file')) {
                return Response::json([
                    'error' => 'Please provide a message or file to send',
                ], 400);
            }

            $error = (object)[
                'status' => 0,
                'message' => null
            ];
            $attachment = null;
            $attachment_title = null;

            // If there is a file in the request
            if ($request->hasFile('file')) {
                // Store the file
                $attachment = Str::uuid() . "." . $request->file('file')->extension();
                $attachment_title = $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs(config('chatify.attachments.folder'), $attachment, config('chatify.storage_disk_name'));
            }

            // Send message to database
            $messageData = [
                'type' => $request['type'],
                'from_id' => $user->user_id,
                'to_id' => $request['user_id'],
                'body' => htmlentities(trim($request['message']), ENT_QUOTES, 'UTF-8'),
                'attachment' => ($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),
                ]) : null,
            ];

            $message = Chatify::newMessage($messageData);

            // Parse the message for the response
            $messageData = Chatify::parseMessage($message);

            // Send to user using pusher
            if ($request['user_id'] != $user->user_id) {
                Chatify::push("private-chatify." . $request['user_id'], 'messaging', [
                    'from_id' => $user->user_id,
                    'to_id' => $request['user_id'],
                    'message' => $messageData
                ]);
            }

            return Response::json([
                'status' => '200',
                'error' => $error,
                'message' => $messageData,
                'tempID' => $request['temporaryMsgId'],
            ]);

        } catch (\Exception $e) {
            Log::error('Message Send Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Response::json([
                'status' => '500',
                'error' => (object)[
                    'status' => 1,
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JSON response
     */
    public function fetch(Request $request)
    {
        $query = Chatify::fetchMessagesQuery($request['user_id'])->latest();
        $messages = $query->paginate($request->per_page ?? $this->perPage);
        $totalMessages = $messages->total();
        $lastPage = $messages->lastPage();
        $response = [
            'total' => $totalMessages,
            'last_page' => $lastPage,
            'last_message_id' => collect($messages->items())->last()->id ?? null,
            'messages' => $messages->items(),
        ];
        return Response::json($response);
    }

    /**
     * Make messages as seen
     *
     * @param Request $request
     * @return void
     */
    public function seen(Request $request)
    {
        // make as seen
        $seen = Chatify::makeSeen($request['user_id']);
        // send the response
        return Response::json([
            'status' => $seen,
        ], 200);
    }

    /**
     * Get contacts list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse response
     */
    public function getContacts(Request $request)
    {
        // get all users that received/sent message from/to [Auth user]
        $users = Message::join('users',  function ($join) {
            $join->on('ch_messages.from_id', '=', 'users.user_id')
                ->orOn('ch_messages.to_id', '=', 'users.user_id');
        })
        ->where(function ($q) {
            $q->where('ch_messages.from_id', Auth::user()->user_id)
            ->orWhere('ch_messages.to_id', Auth::user()->user_id);
        })
        ->where('users.user_id','!=',Auth::user()->user_id)
        ->select('users.*',DB::raw('MAX(ch_messages.created_at) max_created_at'))
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.user_id')
        ->paginate($request->per_page ?? $this->perPage);

        return response()->json([
            'contacts' => $users->items(),
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }

    /**
     * Put a user in the favorites list
     *
     * @param Request $request
     * @return void
     */
    public function favorite(Request $request)
    {
        $userId = $request['user_id'];
        // check action [star/unstar]
        $favoriteStatus = Chatify::inFavorite($userId) ? 0 : 1;
        Chatify::makeInFavorite($userId, $favoriteStatus);

        // send the response
        return Response::json([
            'status' => @$favoriteStatus,
        ], 200);
    }

    /**
     * Get favorites list
     *
     * @param Request $request
     * @return void
     */
    public function getFavorites(Request $request)
    {
        $favoritesList = null;
        $favorites = Favorite::where('user_id', Auth::user()->user_id);
        foreach ($favorites->get() as $favorite) {
            // get user data
            $user = User::where('user_id', $favorite->favorite_id)->first();
            $favoritesList .= view('Chatify::layouts.favorite', [
                'user' => $user,
            ]);
        }
        // send the response
        return Response::json([
            'count' => $favorites->count(),
            'favorites' => $favorites->count() > 0
                ? $favoritesList
                : 0,
        ], 200);
    }

    /**
     * Search in messenger
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $getRecords = null;
        $input = trim(filter_var($request['input']));
        $records = User::where('user_id','!=',Auth::user()->user_id)
                    ->where('name', 'LIKE', "%{$input}%")
                    ->paginate($request->per_page ?? $this->perPage);
        foreach ($records->items() as $record) {
            $getRecords .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'user' => Chatify::getUserWithAvatar($record),
            ])->render();
        }
        if($records->total() < 1){
            $getRecords = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }
        // send the response
        return Response::json([
            'records' => $getRecords,
            'total' => $records->total(),
            'last_page' => $records->lastPage()
        ], 200);
    }

    /**
     * Get shared photos
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sharedPhotos(Request $request)
    {
        $images = Chatify::getSharedPhotos($request['user_id']);

        foreach ($images as $image) {
            $image = asset(config('chatify.attachments.folder') . $image);
        }
        // send the response
        return Response::json([
            'shared' => $images ?? [],
        ], 200);
    }

    /**
     * Delete conversation
     *
     * @param Request $request
     * @return void
     */
    public function deleteConversation(Request $request)
    {
        // delete
        $delete = Chatify::deleteConversation($request['id']);

        // send the response
        return Response::json([
            'deleted' => $delete ? 1 : 0,
        ], 200);
    }

    public function updateSettings(Request $request)
    {
        $msg = null;
        $error = $success = 0;

        // dark mode
        if ($request['dark_mode']) {
            $request['dark_mode'] == "dark"
                ? User::where('user_id', Auth::user()->user_id)->update(['dark_mode' => 1])
                : User::where('user_id', Auth::user()->user_id)->update(['dark_mode' => 0]);
        }

        // If messenger color selected
        if ($request['messengerColor']) {
            $messenger_color = trim(filter_var($request['messengerColor']));
            User::where('user_id', Auth::user()->user_id)
                ->update(['messenger_color' => $messenger_color]);
        }
        // if there is a [file]
        if ($request->hasFile('avatar')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();

            $file = $request->file('avatar');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed_images)) {
                    // delete the older one
                    if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                        $avatar = Auth::user()->avatar;
                        if (Chatify::storage()->exists($avatar)) {
                            Chatify::storage()->delete($avatar);
                        }
                    }
                    // upload
                    $avatar = Str::uuid() . "." . $file->extension();
                    $update = User::where('user_id', Auth::user()->user_id)->update(['avatar' => $avatar]);
                    $file->storeAs(config('chatify.user_avatar.folder'), $avatar, config('chatify.storage_disk_name'));
                    $success = $update ? 1 : 0;
                } else {
                    $msg = "File extension not allowed!";
                    $error = 1;
                }
            } else {
                $msg = "File size you are trying to upload is too large!";
                $error = 1;
            }
        }

        // send the response
        return Response::json([
            'status' => $success ? 1 : 0,
            'error' => $error ? 1 : 0,
            'message' => $error ? $msg : 0,
        ], 200);
    }

    /**
     * Set user's active status
     *
     * @param Request $request
     * @return void
     */
    public function setActiveStatus(Request $request)
    {
        try {
            $activeStatus = $request['status'] > 0 ? 1 : 0;
            $user = Auth::user();
            
            Log::info('Attempting to update active status', [
                'user_id' => $user->user_id,
                'current_status' => $user->active_status,
                'new_status' => $activeStatus
            ]);

            $status = User::where('user_id', $user->user_id)
                        ->update(['active_status' => $activeStatus]);
            
            Log::info('Active Status Update Result', [
                'update_success' => $status,
                'user_id' => $user->user_id,
                'new_status' => $activeStatus
            ]);
            
            return Response::json([
                'status' => $status,
                'active_status' => $activeStatus
            ], 200);
        } catch (\Exception $e) {
            Log::error('Active Status Update Error', [
                'error' => $e->getMessage(),
                'user_id' => Auth::user()->user_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return Response::json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function idInfo(Request $request)
    {
        $user = User::where('user_id', $request['user_id'])->first();
        
        if(!$user){
            return Response::json([
                'message' => 'User not found!',
            ], 401);
        }

        return Response::json([
            'fetch' => array_merge(
                $user->toArray(),
                ['avatar' => Chatify::getUserWithAvatar($user)->avatar]
            ),
        ], 200);
    }
}
