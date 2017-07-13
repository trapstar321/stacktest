requirejs.config({
    paths: {
        'text': '../lib/require/text',
        'durandal':'../lib/durandal/js',
        'plugins' : '../lib/durandal/js/plugins',
        'transitions' : '../lib/durandal/js/transitions',
        'knockout': '../lib/knockout/knockout-3.4.0',
        'bootstrap': '../lib/bootstrap/js/bootstrap',
        'jquery': '../lib/jquery/jquery-1.9.1',
        'auth':'../lib/auth'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery'],
            exports: 'jQuery'
       }
    }
});

define('httpError', ['durandal/app', 'knockout', 'plugins/router', 'routesConfig'],
    function(app, ko, router, routesConfig){
        return {
            handleError:function(data){
                if(data.status!=401){
                    app.showMessage(data.responseText.length>0?data.responseText:"An error occured", data.status+" "+data.statusText, ["OK"]).then(function(dialogResult){
                            if(dialogResult === "OK"){                            
                                router.navigate("home");
                            }
                        }); 
                }
            }
        }
    }
);

define('user', ['durandal/app', 'knockout', 'plugins/router', 'routesConfig'],
    function (app, ko, router, routesConfig) {
        return {
            token:ko.observable(),
            user_id:ko.observable(),
            firstname:ko.observable(),
            lastname:ko.observable(),            
            welcome:function(){                
                return "Welcome "+this.firstname()+" "+this.lastname();
            },
            loggedin:ko.observable(false),            
            login:function(response){
                this.token(response.token);
                this.user_id(response.user_id);
                this.firstname(response.firstname);
                this.lastname(response.lastname);
                this.loggedin(true);

                router.reset();
                router.map([
                    routesConfig.loggedInRoutes
                ]).buildNavigationModel();                
                
                router.navigate('home');  
            },
            logout:function(redirect){                   
                this.token(undefined);
                this.user_id(undefined);
                this.firstname(undefined);
                this.lastname(undefined);
                this.loggedin(false);    

                router.reset();
                router.map([
                    routesConfig.defaultRoutes
                ]).buildNavigationModel();                
                
                if(redirect)
                    router.navigate('home');                            
            },
            error:function(data){                
                if(data.status==401){
                    var self=this;
                    app.showMessage('You are not logged in.', 'Unauthorized error', ["Login"]).then(function(dialogResult){
                        if(dialogResult === "Login"){
                            self.logout(false);
                            router.navigate("login");
                        }
                    });                    
                }
            },
            authCheck:function(){
                var dfd = $.Deferred();
                if(!this.loggedin())
                    dfd.resolve({'redirect': 'login'});
                else
                    dfd.resolve(true);            

                return dfd;
            }
        }
    }
);

define(['durandal/system', 'durandal/app', 'durandal/viewLocator', 'bootstrap'],  function (system, app, viewLocator) {
    //>>excludeStart("build", true);
    system.debug(true);
    //>>excludeEnd("build");

    app.title = 'News';

    app.configurePlugins({
        router:true,
        dialog: true
    });

    app.start().then(function() {
        //Replace 'viewmodels' in the moduleId with 'views' to locate the view.
        //Look for partial views in a 'views' folder in the root.
        viewLocator.useConvention();

        //Show the app by setting the root view model for our application with a transition.
        app.setRoot('viewmodels/shell', 'entrance');
    });
});