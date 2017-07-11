define(['durandal/app', 'plugins/http', 'knockout', 'plugins/router'], function (app, http, ko, router) {    
    return {
        displayName: 'Get news by id',
        title: ko.observable(),     
        text: ko.observable(),     
        short_desc: ko.observable(),     
        img_path: ko.observable(),             
        activate: function () {
            id = router.activeInstruction().params[0]
            var self=this;
            http.get("/stacktest/public/news/"+id, {})
            .success(function(response) {                                                                
                self.title(response.title);
                self.short_desc(response.short_desc);
                self.img_path(response.img_path);
                self.text(response.text);

                document.title=self.title();
            })
            .error(function(data){
                
            });
        },
    };
});