define(['durandal/app', 'plugins/http', 'knockout', 'user'], function (app, http, ko, user) {    
    return {
        displayName: 'My news',
        news: ko.observableArray(),  
        canActivate: function () {               
            return user.authCheck();            
        },       
        activate: function () {
            var news = this.news;
            http.get("/stacktest/public/news/my", {}, {Authorization:user.token(), UserID:user.user_id()})
            .success(function(response) {                                                
                response.forEach(function(element){
                    element.link="index.html#news/"+element.id;
                });
                news(response);                
            })
            .error(function(data){                
                user.error(data);
            });
        },
    };
});