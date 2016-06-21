// JavaScript Document

function logout(){
        new Request(
        {
                url        : "logout.php",
                method     : 'post',
                handleAs   : 'text',
                parameters : {},
                onSuccess  : function() {
                        document.location.href="index.php";
                },
                onError    : function(status, message) {
                        window.alert('Error ' + status + ': ' + message) ;
                }
        });
}
