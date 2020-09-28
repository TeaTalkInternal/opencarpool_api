<?php
include "pool_push_notifier.php";
//you may test your notification here
sendNotification("your message", "your device APNS token", "booking_id", "1");
