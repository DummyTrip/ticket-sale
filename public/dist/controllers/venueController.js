/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('venueController',['$scope', 'VenueServices' , function($scope, VenueServices) {
    var self = this;
    self.venue = { id:'', name:'', city:'',country:'', address:''};
    self.venues = [];

    self.fetchAllVenues = function(){
        console.log("Ovde sum");
        VenueServices.fetchAllVenues()
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
        console.log("Ova e vo controlerot: "+ self.venue.name+" "+self.venue.city+" "+self.venue.country+" "+self.venue.address);
        VenueServices.createVenue(self.venue)
            .then(
                function(){
                    console.log('Kreirana '+self.venue.name);
                },
                function(errResponse){
                    console.log('Error while creating venue in VenueController')
                }
            )
    };
    self.showVenue = function(venue){
        VenueServices.showVenue(venue.id)
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
        VenueServices.editOrUpdate(venue.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while editing or updating venue in VenueController');
                }
            )

    };
    self.fetchAllVenues();
}]);