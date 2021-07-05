<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends ApiController
{

    public function index(){
    	return $notifications = auth()->user()->notifications;
    }

    public function unreadNotifications(){
    	return $notifications = auth()->user()->unreadNotifications;
    }
    public function read($id){
    	DatabaseNotification::find($id)->markAsRead();
    	return $notifications = auth()->user()->unreadNotifications;
    }
}
