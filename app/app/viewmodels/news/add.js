define(['durandal/app', 'plugins/http', 'knockout', 'plugins/router', 'user'], function (app, http, ko, router, user) {    
    return {
        displayName: 'Add news',        
        title: ko.observable(),
        short_desc: ko.observable(),
        text: ko.observable(),
        canActivate: function () {              
            return user.authCheck();            
        },            
        reset:function(){                        
            this.title("");
            this.short_desc("");
            this.text("");
            console.log("Here");
            if($("#add_form")[0]!=undefined)
                $("#add_form")[0].reset()
        },
        activate:function(){
            this.reset();
        },    
        add: function(item) {            
            var fd = new FormData();
            fd.append("title", this.title());
            fd.append("short_desc", this.short_desc());
            fd.append("text", this.text());
            fd.append("img", $("input")[2].files[0]);

            var self=this;
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
                    self.reset();
                    return app.showMessage('News saved');
                },
                error: function(data){
                    user.error(data);
                }
            });
        },
    };
});