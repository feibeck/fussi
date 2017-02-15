import { Routes, RouterModule } from '@angular/router';
import { NoContentComponent } from './no-content/no-content.component';

import { DashboardComponent } from './dashboard/dashboard.component';
import { PlayersComponent } from './players/players.component';
import { PlayerDetailComponent } from './players/player-detail.component';
import { PlayerEditComponent } from './players/player-edit.component';

export const ROUTES: Routes = [
  { path: '',      component: DashboardComponent },
  { path: 'home',  component: DashboardComponent },
  { path: 'player/list', component: PlayersComponent },
  { path: 'player/show/:id', component: PlayerDetailComponent },
  { path: 'player/edit/:id', component: PlayerEditComponent },
  { path: 'player/new', component: PlayerEditComponent },
  { path: '**',    component: NoContentComponent },
];
