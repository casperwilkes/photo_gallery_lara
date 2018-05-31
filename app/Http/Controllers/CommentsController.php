<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photograph;
use Illuminate\Http\Request;
use Log;

class CommentsController extends Controller {

    public function __construct() {
        // All interactions require authentication //
        $this->middleware('auth');
    }

    /**
     * Saves a comment to the database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        // Validate //
        $this->validate($request, array(
            'photo_id' => 'required|integer',
            'comment' => 'required',
        ));

        // Find the photo //
        $photo = Photograph::find($request->input('photo_id'));

        // Make sure photo exists //
        if ($photo->exists()) {
            // Get current user //
            $user = auth()->user()->id;

            // Instatiate a new comment //
            $comment = new Comment();
            $comment->photograph_id = $photo->id;
            $comment->user_id = $user;
            $comment->body = $request->input('comment');

            // Attempt to save //
            if ($comment->save()) {
                $request->session()->flash('success', 'Comment saved successfully');
            } else {
                // Log message //
                Log::error('Unable to save comment at this time', array(
                    'User' => $user,
                    'Photo' => $photo->id,
                    'Comment' => $request->input('comment'),
                ));
                $request->session()->flash('error', 'Unable to save comment at this time.');
            }
        } else {
            $request->session()->flash('error', 'Unable to locate photograph');
        }

        // Redirect user back to photo //
        return redirect()->route('photographs.show', array('photograph' => $photo));
    }

    /**
     * Deletes a comment from the database
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment) {
        // Get user id //
        $user = auth()->user()->id;
        // Base redirect //
        $redirect = array('route' => 'photographs.show', 'params' => array('photograph' => $comment->photograph->id));
        // Base status //
        $message = array('status' => 'error', 'text' => 'You cannot delete this comment',);
        // Log out attr //
        $log = array(
            'user' => $user,
            'photograph' => $comment->photograph->id,
            'comment' => $comment->id,
            'body' => $comment->body,
        );

        // Check access //
        if ($user === $comment->user_id) {
            try {
                // Attempt to delete //
                if ($comment->delete()) {
                    $message['status'] = 'success';
                    $message['text'] = 'Comment successfully deleted';
                    Log::info('Comment was removed', $log);
                } else {
                    $message['text'] = 'Unable to remove comment at this time';
                }
            } catch (\Exception $e) {
                Log::error($e, $log);
                $message['text'] = 'A problem occurred while removing comment.';
            }
        }

        return redirect()
            ->route($redirect['route'], $redirect['params'])
            ->with($message['status'], $message['text']);
    }
}
