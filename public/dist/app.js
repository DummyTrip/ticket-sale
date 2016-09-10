/**
 * Created by Muttley on 8/4/2016.
 */
//Angular stuff.

var app = angular.module('saleAndEvent', ['ngRoute', 'ngStorage']).constant('api_url', 'http://api.timska.dev'); // Creating object app with name saleAndEvent with no dependencies for now ( the empty brackets )

app.config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider){
    $routeProvider
        .when("/",{
            templateUrl: "directives/index.html",
            controller: "eventController as eventCtrl"
        })
        .when("/register",{
            templateUrl: "directives/register.html",
            controller: "UserController as userCtrl"

        })
        .when("/login",{
            templateUrl:"directives/login.html",
            controller: "UserController as userCtrl"
        })
        .when("/history",{
            templateUrl:"directives/history.html",
            controller:"UserController as userCtrl"
        })
        .when("/contactus",{
            templateUrl:"directives/contact.html",
            controller: "UserController as userCtrl"
        })
        .when('/profile',{
            templateUrl:"directives/profile.html",
            controller: "UserController as userCtrl"
            })
        .when('/venues',{
            templateUrl:"directives/venues.html",
            controller: "UserController as userCtrl"
        })
        .when('/events',{
            templateUrl:"directives/events.html",
            controller: "UserController as userCtrl"
        })
        .when('/admin',{
            templateUrl:"directives/admin.html",
            controller: "UserController as userCtrl"
        })
        .when('/addVenue',{
            templateUrl:"directives/addVenue.html",
            controller: "UserController as userCtrl"
        })
        .when('/editVenue',{
            templateUrl:"directives/editVenue.html",
            controller: "UserController as userCtrl"
        })
        .when('/addEvent',{
            templateUrl:"directives/addEvent.html",
            controller: "UserController as userCtrl"
        })
        .when('/editEvent',{
            templateUrl:"directives/editEvent.html",
            controller: "UserController as userCtrl"
        })
        .when('/productDetails',{
            templateUrl:"directives/productDetails.html",
            controller: "UserController as userCtrl"
        })
        .when('/buyCards',{
            templateUrl:"directives/buyCards.html",
            controller: "UserController as userCtrl"
        })
        .when('/listAllVenues',{
            templateUrl:"directives/listAllVenues.html",
            controller:"UserController as userCtrl"
        })
        .when("/users",{
            templateUrl:"directives/users.html",
            controller: "UserController as userCtrl"
        }).otherwise({
         redirectTo: "/"

    });

    // dodava Authorization header na sekoj http request
    // izgleda vaka: Bearer: tokenot-zapishan-vo-localStorage
    $httpProvider.interceptors.push(['$q', '$location', '$localStorage', function ($q, $location, $localStorage) {
        return {
            'request': function (config) {
                config.headers = config.headers || {};
                if ($localStorage.token) {
                    config.headers.Authorization = 'Bearer ' + $localStorage.token;
                }
                return config;
            },
            'responseError': function (response) {
                if (response.status === 401 || response.status === 403) {
                    delete $localStorage.token;
                    $location.path('/login');
                }
                return $q.reject(response);
            }
        };
    }]);
}]);

app.directive("slideit", function() {
    return {
        templateUrl : "directives/slider.html",
        link: function (scope, element, attrs) {
            $(element).nivoSlider();
        }
    };
});
app.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
}
]);

