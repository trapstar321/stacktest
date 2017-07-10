define(['durandal/app', 'plugins/http', 'knockout', 'user', 'plugins/router'], function (app, http, ko, user, router) {    
    return {
        displayName: 'Add news',        
        title: ko.observable(),
        short_desc: ko.observable(),
        text: ko.observable(),
        canActivate: function () {
            //if we have no token and user_id navigate to login page
            if(user.token()==undefined && user.user_id()==undefined){
                return false;
            }
            return true;
        },
        add: function(item) {            
            var fd = new FormData();
            fd.append("title", this.title());
            fd.append("short_desc", this.short_desc());
            fd.append("text", this.text());
            fd.append("img", $("input")[2].files[0]);

            $.ajax({
                url: "/stacktest/public/news/add",
                data: fd,
                processData: false,
                cache: false,
                contentType: false,
                type: 'POST',
                beforeSend:function(request){
                    request.setRequestHeader("Authorization", user.token());
                    request.setRequestHeader("UserID", user.user_id());
                },
                success: function(data){
                    console.log(data);
                },
                error: function(data){
                    console.log(data);
                }
            });
        },
    };
});