$(function ()
{
    var firebaseConfig = {
        apiKey: "AIzaSyA5vcI2Ldd-xhxIPFdfMn7zk71rsH_c2u8",
        authDomain: "schoolquest-de63a.firebaseapp.com",
        databaseURL: "https://schoolquest-de63a.firebaseio.com",
        projectId: "schoolquest-de63a",
        storageBucket: "schoolquest-de63a.appspot.com",
        messagingSenderId: "913587870362",
        appId: "1:913587870362:web:f29f3c42cb82fcd5021d23"
    };
    firebase.initializeApp(firebaseConfig);
    var database = firebase.database();
    /*database.ref('record').set('???');*/
    var record = database.ref('record');
    record.on('value', function (snapshot) {
        $('#record-box > span').text(snapshot.val());
    });

    $(document).on('keyup', function (e) {
        if (e.keyCode == 32) { // spacebar
            alert("Eh, ti piacerebbe..");
        }
    })
    
    $('#start-box').on('click', function (e) {
        alert("Eh, ti piacerebbe..");
    });
});
