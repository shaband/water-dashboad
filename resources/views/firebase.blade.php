
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">


</head>
<body>


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>
{{--

$message = CloudMessage::withTarget('token','f52YOOgdI4m8nlIeYz_Z43:APA91bEtE5BgmWILihZwO2nX6KLmXNDhq7dqbFy0azTnZwq3RpP0Tp1t2NZ4ZLRsMpMaRrjt8Rs6jyNYMKPAPu4Jle0JchpipYQa8VooEAQ2Kuf0R239BuqVn1pZk-MRJy5OtxihBMAV')->withData(['key' => 'value']);
 // optional
--}}
<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyC3n_1V77bt-selQaZRkGaKkDnxSjyGY-Q",
        authDomain: "water-2f227.firebaseapp.com",
        databaseURL: "https://water-2f227.firebaseio.com",
        projectId: "water-2f227",
        storageBucket: "water-2f227.appspot.com",
        messagingSenderId: "1035602743510",
        appId: "1:1035602743510:web:e203904c3770c39a15f977",
        measurementId: "G-RSFD3KB5BD"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // [START get_messaging_object]
    // Retrieve Firebase Messaging object.
    const messaging = firebase.messaging();
    const voip='BKHTBzCh3lJiUKdjXAbnvNqFHxr5mHR2A9yiXAG454FvfURFPWB86_BK8Gfqp4b4w1-wfqYn0jsDcvliE3E36rY';
    messaging.getToken()
        .then(function(currentToken) {
            if (currentToken) {
           //     sendTokenToServer(currentToken);
            } else {
                // Show permission request.
                console.log('No Instance ID token available. Request permission to generate one.');
                requestPermission()
                // Show permission UI.
              //  updateUIForPushPermissionRequired();
              //  setTokenSentToServer(false);
            }
        })
        .catch(function(err) {
       debugger
            console.log('An error occurred while retrieving token. ', err);
      //      showToken('Error retrieving Instance ID token. ', err);
      //      setTokenSentToServer(false);
        });

    function requestPermission() {
        console.log('Requesting permission...');
        // [START request_permission]
        messaging.requestPermission()
            .then(function() {
                console.log('Notification permission granted.');
                // TODO(developer): Retrieve an Instance ID token for use with FCM.
                // [START_EXCLUDE]
                // In many cases once an app has been granted notification permission, it
                // should update its UI reflecting this.
                resetUI();
                // [END_EXCLUDE]
            })
            .catch(function(err) {
                console.log('Unable to get permission to notify.', err);
            });
        // [END request_permission]
    }
</script>
</body>
</html>
