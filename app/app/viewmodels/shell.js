define('routesConfig', ['durandal/app', 'knockout'],
    function(app, ko, user){
        return {
            defaultRoutes:[                
                { route: 'home', title:'Home', moduleId: 'viewmodels/news/today', nav: true},
                { route: 'login', title:'Login', moduleId: 'viewmodels/login', nav: true },                
                { route: 'news/add', title:'Add news', moduleId: 'viewmodels/news/add', nav: false},                
                { route: 'news/my', title:'My news', moduleId: 'viewmodels/news/my', nav: false},
                { route: 'news/(:id)', title:'', moduleId: 'viewmodels/news/get', nav: false},                
            ],
            loggedInRoutes:[
                { route: 'home', title:'Home', moduleId: 'viewmodels/news/today', nav: true }, 
                { route: 'login', title:'Login', moduleId: 'viewmodels/login', nav: false },                
                { route: 'news/add', title:'Add news', moduleId: 'viewmodels/news/add', nav: true},                
                { route: 'news/my', title:'My news', moduleId: 'viewmodels/news/my', nav: true},
                { route: 'news/(:id)', title:'', moduleId: 'viewmodels/news/get', nav: false},
            ]
        }
    }
);

define(['plugins/router', 'durandal/app', 'routesConfig', 'user', 'knockout'], function (router, app, routesConfig, user, ko) {    
    return {
        user:user,
        router: router,    
        search: function() {
            //It's really easy to show a message box.
            //You can add custom options too. Also, it returns a promise for the user's response.
            app.showMessage('Search not yet implemented...');
        },
        activate: function () {
            router.map([
                routesConfig.defaultRoutes
            ]).buildNavigationModel();
            
            return router.activate();
        }
    };
});