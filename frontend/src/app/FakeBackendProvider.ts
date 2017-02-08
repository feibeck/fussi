import { Http, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { PointLog } from './players/point-log.model';

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

const players = [
    {
        id: 1,
        name: 'Player 1',
        points: 1000,
        matchCount: 0
    },
    {
        id: 2,
        name: 'Player 2',
        points: 900,
        matchCount: 1
    },
    {
        id: 3,
        name: 'Player 3',
        points: 1100,
        matchCount: 1
    }
];

const pointLog: PointLog[] = [
    {
        currentPoints1: 1000,
        currentPoints2: 1000,
        newPoints1: 1010,
        newPoints2: 990,
        chance1: 1,
        chance2: 1,
        match: {
            type: 'single',
            date: '2016-01-13',
            player1: {
                id: 1,
                name: 'Foo'
            },
            player2: {
                id: 2,
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
        }
    },
    {
        currentPoints1: 1000,
        currentPoints2: 1000,
        newPoints1: 1010,
        newPoints2: 990,
        chance1: 1,
        chance2: 1,
        match: {
            type: 'single',
            date: '2016-01-13',
            player1: {
                id: 1,
                name: 'Foo'
            },
            player2: {
                id: 2,
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
        }
    }
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

            // GET: /player
            if (connection.request.url === 'http://localhost:8080/api/player' && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(players)
                }));

                connection.mockRespond(response);
            }

            // GET: /player/:id/pointlog
            if (connection.request.url.match(/\/api\/player\/([0-9]+)\/pointlog$/i) && connection.request.method === 0) {

                const id = parseInt(connection.request.url.match(/\/api\/player\/([0-9]+)\/pointlog/i)[1], 10);

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(pointLog)
                }));

                connection.mockRespond(response);
            }

            // GET: /player/:id
            if (connection.request.url.match(/\/api\/player\/([0-9]+)$/i) && connection.request.method === 0) {

                const id = parseInt(connection.request.url.match(/\/api\/player\/([0-9]+)/i)[1], 10);

                let foundPlayer = players.filter((currentPlayer) => {
                    return currentPlayer.id === id;
                }).reduce((_prev, player) => {
                    return player;
                });

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(foundPlayer)
                }));

                connection.mockRespond(response);
            }

        });

        return new Http(backend, options);

    }
};
