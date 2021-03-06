import { Routes, RouterModule } from '@angular/router';
import { NoContentComponent } from './no-content/no-content.component';

import { DashboardComponent } from './dashboard/dashboard.component';
import { PlayerListComponent } from '../player/component/player-list.component';
import { PlayerDetailComponent } from '../player/component/player-detail.component';
import { PlayerEditComponent } from '../player/component/player-edit.component';
import { TournamentListComponent } from '../tournament/component/tournament-list.component';
import { TournamentViewComponent } from '../tournament/component/tournament-view.component';

export const ROUTES: Routes = [
  { path: '',      component: DashboardComponent },
  { path: 'home',  component: DashboardComponent },
  { path: 'player/list', component: PlayerListComponent },
  { path: 'player/show/:id', component: PlayerDetailComponent },
  { path: 'player/edit/:id', component: PlayerEditComponent },
  { path: 'player/new', component: PlayerEditComponent },
  { path: 'tournament/list', component: TournamentListComponent },
  { path: 'tournament/show/:id', component: TournamentViewComponent },
  { path: 'not-found', component: NoContentComponent },
  { path: 'error', component: NoContentComponent },
  { path: '**',    component: NoContentComponent },
];
