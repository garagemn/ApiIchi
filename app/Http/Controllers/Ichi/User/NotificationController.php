<?php

namespace App\Http\Controllers\Ichi\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Oneseller\NotificationResource;
use App\Models\User\IchiOnesellerNotification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index()
    {
        $notifications = IchiOnesellerNotification::where('oneseller_id', auth()->id())->latest('id')->paginate(20);
        $resourceData = NotificationResource::collection($notifications);
        return $this->sendResponsePagination($notifications, $resourceData, '', '');
    }

    public function isread(Request $request)
    {
        $hasNotification = IchiOnesellerNotification::findOrFail($request->get('notificationid'));
        $hasNotification->isread = 1;
        $hasNotification->save();
        return $this->sendResponse('', 'Амжилттай хадгалагдлаа.');
    }
}
