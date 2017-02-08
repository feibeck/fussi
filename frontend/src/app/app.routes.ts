import { Routes, RouterModule } from '@angular/router';
import { NoContentComponent } from './no-content/no-content.component';

import { DashboardComponent } from './dashboard/dashboard.component';
import { PlayersComponent } from './players/players.component';
import { PlayerDetailComponent } from './players/player-detail.component';

export const ROUTES: Routes = [
  { path: '',      component: DashboardComponent },
  { path: 'home',  component: DashboardComponent },
  { path: 'players', component: PlayersComponent },
  { path: 'player/:id', component: PlayerDetailComponent },
  { path: '**',    component: NoContentComponent },
];
