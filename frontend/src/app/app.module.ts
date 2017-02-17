import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { NgModule } from '@angular/core';
import { RouterModule, PreloadAllModules } from '@angular/router';
import { AppComponent } from './app.component';
import { NoContentComponent } from './no-content/no-content.component';
import { FussiNavigationComponent } from './navigation/fussi-navigation.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ActiveTournamentsComponent } from './dashboard/active-tournaments/active-tournaments.component';
import { RecentMatchesComponent } from './dashboard/recent-matches/recent-matches.component';
import { TournamentRankingComponent } from './dashboard/tournament-ranking/tournament-ranking.component';
import { RecentMatchService } from './dashboard/recent-matches/recent-matches.service';
import { PlayerModule } from '../player';
import { SharedModule } from '../shared';
import { FakeBackendModule } from '../fake-backend';
import { ROUTES } from './app.routes';

import '../styles/styles.scss';
import { TournamentModule } from '../tournament/tournament.module';

@NgModule({
  bootstrap: [
      AppComponent
  ],
  declarations: [
    AppComponent,
    NoContentComponent,
    FussiNavigationComponent,
    DashboardComponent,
    ActiveTournamentsComponent,
    RecentMatchesComponent,
    TournamentRankingComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    RouterModule.forRoot(ROUTES, { useHash: true, preloadingStrategy: PreloadAllModules }),
    PlayerModule,
    SharedModule,
    FakeBackendModule,
    TournamentModule
  ],
  providers: [
    RecentMatchService
  ]
})
export class AppModule {
}
