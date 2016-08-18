/**
 * Created by Muttley on 8/4/2016.
 */
//Angular stuff.

var app = angular.module('saleAndEvent', ['ngRoute', 'ngStorage']); // Creating object app with name saleAndEvent with no dependencies for now ( the empty brackets )

app.config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider){
    $routeProvider
        .when("/",{
            templateUrl: "directives/index.html"
        })
        .when("/register",{
            templateUrl: "directives/register.html"

        })
        .when("/login",{
            templateUrl:"directives/login.html"
        })
        .when("/contactus",{
            templateUrl:"directives/contact.html"
        })
        .when('/profile',{
            templateUrl:"directives/profile.html"
            })
        .when('/venues',{
            templateUrl:"directives/venues.html"
        })
        .when('/events',{
            templateUrl:"directives/events.html"
        })
        .when('/admin',{
            templateUrl:"directives/admin.html"
        })
        .when("/users",{
            templateUrl:"directives/users.html"
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

