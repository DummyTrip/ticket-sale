/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('eventController',['$scope', 'EventService', 'VenueServices', function($scope, EventService,VenueServices) {
    var self = this;
    self.event = { name:'', venue_id:'', tag_list:[1,2], date:'',venue:'',editing:''};
    self.tmpevent={name:'',date:'',venue:''};
    self.events = [];
    self.venue = { name:'', id:''};
    self.venues=[];
    self.getIdVenue = function(){
        for(var i = 0; i < self.venues.length; i++){
            console.log('Venue name: '+self.venues[i].name);
            if(self.tmpevent.venue===self.venues[i].name){
                console.log('Entered '+self.venues[i].id);
                self.event.venue_id=self.venues[i].id;
                break;
            }
        }
    };
    self.getVenueByID = function(){
        for(var i = 0; i < self.venues.length; i++){
            if(self.event.venue_id === self.venues[i].id){
                self.event.venue = self.venues[i].name;
                break;
            }
        }
    };
    self.fetchAllVenues=function(){
        VenueServices.fetchAllVenues()
            .then(
                function (d) {
                    self.venues = d;
                },
                function(errResponse){
                    console.log('Error while fetching all venues in eventController');
                }
            )
    };
    self.addValue = function(value){
        alert('Yes');
        var flag = false;
        for(var i = 0; i < self.event.tag_list.length; i++){
            if(self.event.tag_list[i]===value){
                flag = true;
                break;
            }
        }
        if(!flag){
            console.log(value);
            self.event.tags.push(value);
        }
    };





    self.fetchAllEvents = function(){
        EventService.fetchAllEvents()
            .then(
                function(d){
                    self.events = d;
                    for(var i = 0; i < self.events.length; i++){
                        self.event = self.events[i];
                        self.event.editing="false";
                        self.getVenueByID();
                    }

                },
                function (errResponse){
                    console.log('Error while fetching all events in EventController');
                }
            );
    };
    self.createEvent = function(id){
        console.log(id);
        var tmp = ['da', 'ne'];
        self.getIdVenue(self.event);
        console.log(self.event.name+" "+self.event.venue_id+" "+self.event.date+" "+self.event.tag_list+" "+self.events+tmp);
        EventService.createEvent(self.event)
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
    self.fetchAllEvents();


    self.fetchAllVenues();
}]);