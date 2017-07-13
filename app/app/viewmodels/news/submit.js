define(['durandal/app', 'plugins/http', 'knockout', 'plugins/router', 'user', 'httpError'], function (app, http, ko, router, user, he) {    
    return {
        displayName: 'Add or update news',        
        title: ko.observable(),
        short_desc: ko.observable(),
        text: ko.observable(),
        img_path:ko.observable(),
        id:ko.observable(),
        canActivate: function () {              
            return user.authCheck();            
        },            
        reset:function(){                        
            this.title("");
            this.short_desc("");
            this.text("");
            this.img_path("");
            console.log("Here");
            if($("#add_form")[0]!=undefined)
                $("#add_form")[0].reset()
        },
        activate:function(){
            this.reset();    
            var fragment = router.activeInstruction().fragment;
            if(fragment.indexOf("update")!=-1){
                this.id(router.activeInstruction().params[0]);                

                //get news data
                var self = this;
                http.get("/stacktest/public/news/"+this.id(), {})
                    .success(function(response) {                                                                
                        self.title(response.title);
                        self.short_desc(response.short_desc);
                        self.img_path(response.img_path);
                        self.text(response.text);                        
                    })
                    .error(function(data){
                        he.handleError(data);
                    });
            }
        },    
        submit: function(item) {            
            var fd = new FormData();

            if(this.id()!=undefined)
                fd.append("id", this.id());

            fd.append("title", this.title());
            fd.append("short_desc", this.short_desc());
            fd.append("text", this.text());
            fd.append("img", $("input")[2].files[0]);

            var self=this;
            $.ajax({
                url: "/stacktest/public/news/submit",
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
                    app.showMessage('News saved');
                    if(self.id()==undefined)
                        router.navigate("/news/update/"+data.id);
                    else{
                        self.title(data.title);
                        self.short_desc(data.short_desc);                        
                        self.text(data.text);
                        self.img_path(data.img_path);
                    }
                },
                error: function(data){
                    user.error(data);
                    he.handleError(data);
                }
            });
        },
    };
});