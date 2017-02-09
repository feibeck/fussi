/*
 * Angular 2 decorators and services
 */
import {
  Component,
  OnInit,
  ViewEncapsulation
} from '@angular/core';
import { AppState } from './app.service';
import { FussiNavigation } from './navigation/navigation';
import {MockBackend} from "@angular/http/testing";
import {Response, ResponseOptions} from "@angular/http";

/*
 * App Component
 * Top Level Component
 */
@Component({
  selector: 'app',
  encapsulation: ViewEncapsulation.None,
  template: `
    <fussi-main-navigation></fussi-main-navigation>
    <div class="container">
        <router-outlet></router-outlet>
        <hr>
        <footer>
            <p><small>
                Fußi v. (development) -
                Made with <span style="color: red;">♥</span> by
                <a href="https://github.com/feibeck/fussi/graphs/contributors">
                    the Fussi team
                </a>
                using
                    <a href="http://framework.zend.com">Zend Framework 2</a>,
                    <a href="http://doctrine-project.org">Doctrine</a>,
                    <a href="http://twitter.github.com/bootstrap/index.html">
                        Twitter Bootstrap
                    </a>.
                Many thanks to
                    <a href="http://mayflower.de">Mayflower GmbH</a>
                for sponsoring Mayday time!
            </small></p>
            <p>Feeds: <a href="#">Recent matches</a></p>
        </footer>
    </div>
  `
})
export class AppComponent implements OnInit {

    constructor(
        public appState: AppState,
        private backend: MockBackend
    ) {

        this.backend.connections.subscribe( connection => {

            // GET: /tournaments
            if (connection.request.url === "http://localhost:8080/api/tournaments" && connection.request.method === 0) {

                let response = new Response(new ResponseOptions({
                    body: '[{"name":"Tournament 1"},{"name":"Tournament 2"},{"name":"Tournament 3"}]'
                }));

                connection.mockRespond(response);
            }

        });

    }

    public ngOnInit() {
        console.log('Initial App State', this.appState.state);
    }

}
