/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('venueController',['$scope', 'VenueService' , function($scope, VenueService) {
    var self = this;
    self.venue = { id:'', name:'', city:'', address:'' , country:''};
    self.venues = [];

    self.fetchAllVenues = function(){
        VenueService.fetchAllVenues()
            .then(
                function(d){
                    self.venues = d;
                },
                function (errResponse){
                    console.log('Error while fetching all venues in VenueController');
                }
            );
    };
    self.createVenue = function(){
        VenueService.createVenue()
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while creating venue in VenueController')
                }
            )
    };
    self.showVenue = function(venue){
        VenueService.showVenue(venue.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while showing venue in VenueController')
                }
            )
    };
    self.editOrUpdate = function(venue){
        VenueService.editOrUpdate(venue.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while editing or updating venue in VenueController');
                }
            )

    };
}]);