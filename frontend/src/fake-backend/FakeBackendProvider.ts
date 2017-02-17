import { Http, BaseRequestOptions, Response, ResponseOptions, RequestMethod } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { JsonPointLog } from '../player/model/json-point-log.model';

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

const pointLog: JsonPointLog[] = [
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

const tournaments = [
    {
        id: 1,
        name: 'Tournament 1',
        type: 'League',
        active: true
    },
    {
        id: 2,
        name: 'Tournament 2',
        type: 'League',
        active: false
    },
    {
        id: 3,
        name: 'Tournament 3',
        type: 'Tournament',
        active: true
    }
];

export let fakeBackendProvider = {
    provide: Http,
    deps: [MockBackend, BaseRequestOptions],
    useFactory: (backend: MockBackend, options: BaseRequestOptions) => {

        backend.connections.subscribe((connection: MockConnection) => {

            // GET: /tournaments
            if (connection.request.url === 'http://localhost:8080/api/tournament'
                && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(tournaments)
                }));

                connection.mockRespond(response);
            }

            // GET: /tournaments
            if (connection.request.url === 'http://localhost:8080/api/tournament?state=active'
                && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: JSON.stringify(tournaments.filter((tournament) => { return tournament.active; }))
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
                });

                let response;

                if (foundPlayer.length > 0) {

                    response = new Response(new ResponseOptions({
                        body: JSON.stringify(foundPlayer[0])
                    }));
                    connection.mockRespond(response);

                } else if (id === 666) {

                    response = new Response(new ResponseOptions({
                        status: 500
                    }));
                    connection.mockError(response);

                } else {

                    response = new Response(new ResponseOptions({
                        status: 404
                    }));
                    connection.mockError(response);

                }

            }

            if (connection.request.url === 'http://localhost:8080/api/player'
                && connection.request.method === RequestMethod.Put) {

                let requestPlayer = JSON.parse(connection.request.getBody());
                let response;

                if (requestPlayer.name === 'God') {

                    const error = {
                        errors: [
                            {
                                field: 'name',
                                message: 'No one is allowed to be god'
                            }
                        ]
                    };

                    response = new Response(new ResponseOptions({
                        body: JSON.stringify(error),
                        status: 422
                    }));

                    connection.mockError(response);

                } else if (requestPlayer.name === 'Foo') {

                    response = new Response(new ResponseOptions({
                        body: 'Unknown error',
                        status: 500
                    }));
                    connection.mockError(response);

                } else {

                    let foundPlayer = players.filter((currentPlayer) => {
                        return currentPlayer.id === requestPlayer.id;
                    }).reduce((_prev, player) => {
                        return player;
                    });

                    foundPlayer.name = requestPlayer.name;

                    response = new Response(new ResponseOptions({
                        body: JSON.stringify(foundPlayer)
                    }));

                    connection.mockRespond(response);

                }

            }

            if (connection.request.url === 'http://localhost:8080/api/player'
                && connection.request.method === RequestMethod.Post) {

                let requestPlayer = JSON.parse(connection.request.getBody());
                let response;

                if (requestPlayer.name === 'God') {

                    const error = {
                        errors: [
                            {
                                field: 'name',
                                message: 'No one is allowed to be god'
                            }
                        ]
                    };

                    response = new Response(new ResponseOptions({
                        body: JSON.stringify(error),
                        status: 422
                    }));

                    connection.mockError(response);

                } else {

                    let foundPlayerList = players.filter((currentPlayer) => {
                        return currentPlayer.name === requestPlayer.name;
                    });
                    if (foundPlayerList.length > 0) {

                        let foundPlayer = foundPlayerList[0];

                        const error = {
                            errors: [
                                {
                                    field: 'name',
                                    message: 'Name is already in use by another player.'
                                }
                            ]
                        };

                        response = new Response(new ResponseOptions({
                            body: JSON.stringify(error),
                            status: 422
                        }));

                        connection.mockError(response);

                    } else {

                        let highestId = players.map((player) => {
                            return player.id;
                        }).reduce((prev, current) => {
                            return prev > current ? prev : current;
                        });

                        let newPlayer = {
                            id: highestId + 1,
                            name: requestPlayer.name,
                            points: 0,
                            matchCount: 0
                        };

                        players.push(newPlayer);

                        response = new Response(new ResponseOptions({
                            body: JSON.stringify(newPlayer),
                            status: 201
                        }));

                        connection.mockRespond(response);

                    }

                }

            }

        });

        return new Http(backend, options);

    }
};
