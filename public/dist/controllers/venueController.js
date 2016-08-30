/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('venueController',['$scope', 'VenueServices' , function($scope, VenueServices) {
    var self = this;
    self.venue = { id:'', name:'', city:'',country:'', address:'',blocks:[], block:[
        {
            name: '',
            rows: '',
            columns: ''
        }
        ]};
    self.number = Number(0);
    self.tmp =[{name:'',row:'',columns:''}];
    self.venues = [];


    self.addNewBlock = function () {
        self.venue.block.push({
            name: '',
            rows: '',
            columns: ''
        });
    };
    self.fetchAllVenues = function(){
        console.log("Ovde sum");
        VenueServices.fetchAllVenues()
            .then(
                function(d){
                    self.venues = d;

                    //console.log(d);
                },
                function (errResponse){
                    console.log('Error while fetching all venues in VenueController');
                }
            );
    };
    self.createVenue = function(){
        var p = 0;
        for(var i = 0; i < self.venue.block.length; i++){
            self.venue.blocks[p++] = self.venue.block[i].name;
            self.venue.blocks[p++] = self.venue.block[i].rows;
            self.venue.blocks[p++] = self.venue.block[i].columns;
        }
        console.log('Venue: ', self.venue);
        console.log("Ova e vo controlerot: "+self.venue.blocks+" "+self.venue.name+" "+self.venue.city+" "+self.venue.country+" "+self.venue.address);
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
        self.venue = venue;
        console.log(self.venue+" OVa e venue "+JSON.stringify(self.venue));
        VenueServices.editOrUpdate(self.venue)
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