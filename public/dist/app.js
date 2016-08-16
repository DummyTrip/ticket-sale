/**
 * Created by Muttley on 8/4/2016.
 */
//Angular stuff.

var app = angular.module('saleAndEvent', ['ngRoute']); // Creating object app with name saleAndEvent with no dependencies for now ( the empty brackets )

app.config(function($routeProvider){
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
        .when("/admin",{
            templateUrl:"directives/admin.html"
        })
});

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

