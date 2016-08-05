/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('eventController',['$scope', 'EventService' , function($scope, EventService) {
    var self = this;
    self.event = { name:'', date:''};
    self.events = [];

    self.fetchAllEvents = function(){
        EventService.fetchAllVenues()
            .then(
                function(d){
                    self.event = d;
                },
                function (errResponse){
                    console.log('Error while fetching all events in EventController');
                }
            );
    };
    self.createEvent = function(){
        EventService.createEvent()
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while creating event in EventController')
                }
            )
    };
    self.showEvent = function(event){
        EventService.showVenue(event.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while showing events in EventController')
                }
            )
    };
    self.editOrUpdate = function(event){
        EventService.editOrUpdate(event.id)
            .then(
                function(d){
                    self.event = d;
                },
                function(errResponse){
                    console.log('Error while editing or updating event in EventController');
                }
            )

    };
}]);