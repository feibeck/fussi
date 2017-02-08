import { Http, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';

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


        });

        return new Http(backend, options);

    }
};
