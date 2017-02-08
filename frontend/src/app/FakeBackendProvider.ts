import { Http, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';

const latestMatches = [
    {
        type: 'single',
        date: '2016-01-13',
        player1: {
            name: 'Foo'
        },
        player2: {
            name: 'Bar'
        },
        tournamentName: 'Tournament 1',
        isTeamOneWinner: true,
        isTeamTwoWinner: false,
        games: [
            {
                goalsTeamOne: 4,
                goalsTeamTwo: 10
            },
            {
                goalsTeamOne: 3,
                goalsTeamTwo: 10
            }
        ]
    },
    {
        type: 'double',
        date: '2016-01-13',
        team1: {
            name: 'Foo'
        },
        team2: {
            name: 'Bar'
        },
        tournamentName: 'Tournament 2',
        isTeamOneWinner: false,
        isTeamTwoWinner: true,
        games: [
            {
                goalsTeamOne: 10,
                goalsTeamTwo: 1
            },
            {
                goalsTeamOne: 0,
                goalsTeamTwo: 10
            },
            {
                goalsTeamOne: 10,
                goalsTeamTwo: 5
            }
        ]
    },
];


export let fakeBackendProvider = {
    provide: Http,
    deps: [MockBackend, BaseRequestOptions],
    useFactory: (backend: MockBackend, options: BaseRequestOptions) => {

        backend.connections.subscribe((connection: MockConnection) => {

            // GET: /tournaments
            if (connection.request.url === 'http://localhost:8080/api/tournaments' && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: '[{"name":"Tournament 1"},{"name":"Tournament 2"},{"name":"Tournament 3"}]'
                }));

                connection.mockRespond(response);
            }

            // GET: /matches
            if (connection.request.url === 'http://localhost:8080/api/matches' && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(latestMatches)
                }));

                connection.mockRespond(response);
            }


        });

        return new Http(backend, options);

    }
};
