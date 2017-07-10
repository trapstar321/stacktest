define(['durandal/app', 'plugins/http', 'knockout'], function (app, http, ko) {    
    return {
        displayName: 'Today news',
        news: ko.observableArray(),     
        activate: function () {
            var news = this.news;
            http.get("/stacktest/public/news/today", {})
            .success(function(response) {                                
                //news(response);                               
                news(response);
                console.log(news());
            })
            .error(function(data){
                
            });
        },
    };
});