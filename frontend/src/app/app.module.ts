import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { NgModule } from '@angular/core';
import { RouterModule, PreloadAllModules } from '@angular/router';
import { ENV_PROVIDERS } from './environment';
import { ROUTES } from './app.routes';
import { AppComponent } from './app.component';
import { APP_RESOLVER_PROVIDERS } from './app.resolver';
import { InternalStateType } from './app.service';
import { NoContentComponent } from './no-content/no-content.component';
import '../styles/styles.scss';
import { FussiNavigationComponent } from './navigation/fussi-navigation.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ActiveTournamentsComponent } from './dashboard/active-tournaments/active-tournaments.component';
import { RecentMatchesComponent } from './dashboard/recent-matches/recent-matches.component';
import { TournamentRankingComponent } from './dashboard/tournament-ranking/tournament-ranking.component';
import { RecentMatchService } from './dashboard/recent-matches/recent-matches.service';
import { TournamentService } from './service/tournament.service';
import { fakeBackendProvider } from './FakeBackendProvider';
import { PlayerModule } from '../player';
import { SharedModule } from '../shared';
import { FakeBackendModule } from '../fake-backend/fake-backend.module';

// Application wide providers
const APP_PROVIDERS = [
    ...APP_RESOLVER_PROVIDERS,
    RecentMatchService,
    TournamentService
];

/**
 * `AppModule` is the main entry point into Angular2's bootstraping process
 */
@NgModule({
  bootstrap: [ AppComponent ],
  declarations: [
    AppComponent,
    NoContentComponent,
    FussiNavigationComponent,
    DashboardComponent,
    ActiveTournamentsComponent,
    RecentMatchesComponent,
    TournamentRankingComponent
  ],
  imports: [ // import Angular's modules
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    RouterModule.forRoot(ROUTES, { useHash: true, preloadingStrategy: PreloadAllModules }),
    PlayerModule,
    SharedModule,
    FakeBackendModule
  ],
  providers: [ // expose our Services and Providers into Angular's dependency injection
    ENV_PROVIDERS,
    APP_PROVIDERS
  ]
})
export class AppModule {
}
