define(['durandal/app', 'plugins/http', 'knockout', 'httpError'], function (app, http, ko, he) {    
    return {
        displayName: 'Today news',
        news: ko.observableArray(),     
        activate: function () {
            var news = this.news;
            http.get("/stacktest/public/news/today", {})
            .success(function(response) {                                                
                response.forEach(function(element){
                    element.link="index.html#news/"+element.id;
                });
                news(response);                
            })
            .error(function(data){
                he.handleError(data);
            });
        },
    };
});