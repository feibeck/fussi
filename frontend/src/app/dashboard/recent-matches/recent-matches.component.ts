import { Component, OnInit } from '@angular/core';
import {RecentMatchService} from "./recent-matches.service";

@Component({
    selector: 'recent-matches',
    templateUrl: './recent-matches.component.html'
})
export class RecentMatchesComponent implements OnInit {

    public matches = [];

    constructor(private recentMatchService: RecentMatchService) {

    }

    ngOnInit() {
        this.recentMatchService.getRecentMatches().subscribe(matches => this.matches = matches);
    }

}
