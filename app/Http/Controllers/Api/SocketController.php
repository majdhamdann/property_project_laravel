<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\Review;

class SocketController implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $conn) {
        $conn->send('مرحبًا، تم فتح اتصال سوكيت جديد!');
    }

    public function onClose(ConnectionInterface $conn) {
        $conn->send('تم إغلاق اتصال السوكيت. شكرًا لاستخدامك الخدمة!');
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $errorMessage = $e->getMessage();
    $conn->send('حدث خطأ في اتصال السوكيت: ' . $errorMessage);
    }

    public function onMessage(ConnectionInterface $conn, $message) {
        // معالجة استلام الرسالة
        // استلام تقييم العميل ومعلومات العقار من الرسالة
        $data = json_decode($message, true);
        $propertyId = $data['property_id'];
        $rating = $data['rating'];
        $comment = $data['comment'];

        // حفظ التقييم في قاعدة البيانات
        $review = new Review();
        $review->property_id = $propertyId;
        $review->rating = $rating;
        $review->comment = $comment;
        $review->save();

        // إرسال رسالة إجابة لتأكيد حفظ التقييم
        $conn->send('تم حفظ التقييم بنجاح!');
    }
}
