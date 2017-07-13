define(['durandal/app', 'plugins/http', 'knockout', 'plugins/router', 'httpError'], function (app, http, ko, router, he) {    
    return {
        displayName: 'Get news by id',
        title: ko.observable(),     
        text: ko.observable(),     
        short_desc: ko.observable(),     
        img_path: ko.observable(),             
        reset:function(){
            this.title("");
            this.text("");
            this.short_desc("");
            this.img_path("");
        },
        activate: function () {
            this.reset();
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
                he.handleError(data);
            });
        },
    };
});