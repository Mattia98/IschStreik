<?php
	echo "===Notification sender script===\n";
	echo date("r");
	echo "\n";
	
    require '../vendor/autoload.php';
	use Minishlink\WebPush\WebPush;
    include_once '../model/PushSubscription.class.php';
	
    echo "Loading subscriptions..\n";
    $subscriptions = PushSubscription::findAll();
    $notifications = array();

    $auth = array( 
        'VAPID' => array(
            'subject' => 'mailto:sciopero.news@gmail.com',
            'publicKey' => 'BE90HmIQXF4Yp_S6gETYlFuV0mKohszQchwiSQ0BmmkhO07ZnssO6lIehBTtmy-6wi2WhDWIY0x5wuy3pIQzHF0',
            'privateKey' => 'P6mcOlv7iApWg_Z3WEj4mZNnN7lcEPGDHe5KQnciSNw'
        ),
    );
    $webPush = new WebPush($auth);

    foreach($subscriptions as $subscription) {
        $webPush->sendNotification($subscription->getUrl());
    }
    echo "done.\n";

    echo "Sending..\n";
    $webPush->flush();
    echo "done.\n";
?>
