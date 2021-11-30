
//var wistia_vid_div = document.getElementById("wistia_vid");
//console.log(wistia_vid_div);


jQuery(document).ready(function($){
    //alert('Hello World!');

    var ajaxurl = "/wp-admin/admin-ajax.php";

    var wistia_vid_div = jQuery('#wistia_vid');
    console.log(wistia_vid_div);
    console.log(wistia_vid_div[0].id);

    var video;

    window._wq = window._wq || [];

    _wq.push({ 
        id: 'bcqogyv52u', 
        options: {
            autoPlay:true,
            width: 400,
            height: 300,
            controlsVisibleOnLoad: true,
            fitStrategy: 'contain',
            fullscreenButton: true,
            muted: false
        },
        onReady: function(v) {
            video = v;
            video.bind("play", function(){
                console.log("play");
            });

            video.bind("secondchange", function(s) {

                if(s === 10) {
                    console.log("Hit the 10 second mark");

                    video.pause();

                    var data = {
                        action: 'is_user_logged_in'
                    };
                    
                    jQuery.post(ajaxurl, data, function(response) {
                        if(response == 'yes') {
                            // user is logged in, do your stuff here
                            console.log ("User is logged in.");
                        } else {
                            // user is not logged in, show login form here
                            console.log( "User NOT LOGGED IN");
                        }
                    });


                }
            })
        }
    });

    //var video = Wistia.api("bcqogyv52u");
//console.log("I got a handle to the video!", video);


});

