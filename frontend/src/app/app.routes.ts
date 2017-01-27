import { Routes, RouterModule } from '@angular/router';
import { NoContentComponent } from './no-content/no-content.component';

import { DataResolver } from './app.resolver';
import { DashboardComponent } from './dashboard/dashboard.component';
import { PlayersComponent } from './players/players.component';

export const ROUTES: Routes = [
  { path: '',      component: DashboardComponent },
  { path: 'home',  component: DashboardComponent },
  { path: 'players', component: PlayersComponent },
  { path: '**',    component: NoContentComponent },
];
