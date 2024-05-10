<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;


class ChatController extends Controller
{
      public function storechat(Request $request)
{
    // استلم البيانات المرسلة في الطلب
    $data = $request->all();

    // قم بإنشاء سجل جديد في جدول الشات
    $chat = Chat::create($data);

    // قم بإرجاع رد ناجح
    return response()->json(['message' => 'تم حفظ الرسالة بنجاح'], 201);
}
public function indexchat()
{
    // استرجع جميع رسائل الشات
    $chats = Chat::all();

    // قم بإرجاع رسائل الشات كجزء من الاستجابة
    return response()->json($chats, 200);
}


}
