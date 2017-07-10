define(['durandal/app', 'plugins/http', 'knockout', 'user'], function (app, http, ko, user) {    
    return {
        displayName: 'Login',
        username: ko.observable(),
        password: ko.observable(),
        response: ko.observable(),
        login: function(item) {
            response = this.response;                        
            http.post("/stacktest/public/auth/login", {username:this.username(), password:this.password()})
            .success(function(response) {
                user.token(response.token);
                user.user_id(response.user_id);                

                console.log(user.token());                
            })
            .error(function(data){
                response(data.responseText);                
            });
        },
    };
});