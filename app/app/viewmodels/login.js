define(['durandal/app', 'plugins/http', 'plugins/router', 'knockout', 'user', 'routesConfig'], function (app, http, router, ko, user, routesConfig) {        
    return {        
        displayName: 'Login',
        username: ko.observable(),
        password: ko.observable(),
        response: ko.observable(),
        reset:function(){                        
            this.username("");
            this.password("");
            this.response("");            
        },
        activate:function(){
            this.reset();
        }, 
        login: function(item) {
            response = this.response;                                    
            http.post("/stacktest/public/auth/login", {username:this.username(), password:this.password()})            
            .success(function(response) {
                user.login(response);                                           
            })
            .error(function(data){
                response(data.responseText);                
            });
        },
    };
});