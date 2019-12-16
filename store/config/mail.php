<?php

return [
  "driver" => "smtp",
  "host" => "smtp.mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "robot@store.com",
      "name" => "My Store"
  ),
  "username" => "e0099f7e4a5681",
  "password" => "c397d86d06c35a",
  "sendmail" => "/usr/sbin/sendmail -bs"
];
