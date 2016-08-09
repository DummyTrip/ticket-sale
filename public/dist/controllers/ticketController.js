/**
 * Created by Muttley on 8/7/2016.
 */
'use strict';

app.controller('ticketController',['$scope', 'TicketService' , function($scope, TicketService) {
    var self = this;
    self.ticket = {event: '', seat: '', price: ''};
    self.tickets = [];

    self.fetchAllEvents = function () {
        TicketService.fetchAllTicket(Event)
            .then(
                function (d) {
                    self.tickets = d;
                },
                function (errResponse) {
                    console.log('Error while fetching ticket in TicketController');
                }
            );
    };
    self.buyTickets= function (tickets, events){
        TicketService.buyTickets(tickets, events)
            .then(
                function (d) {
                    self.ticket = d;
                },
                function(errResponse){
                    console.log('Error while buying tickets in TicketController');
                }
            )
    }
}]);