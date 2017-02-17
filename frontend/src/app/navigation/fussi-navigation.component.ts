import { Component, OnInit, ViewEncapsulation, ElementRef, HostListener } from '@angular/core';
import { TournamentService } from '../../tournament/service/tournament.service';
import { Tournament } from '../../tournament/model/tournament.model';

@Component({
    selector: 'fussi-main-navigation',
    encapsulation: ViewEncapsulation.None,
    templateUrl: './fussi-navigation.component.html'
})
export class FussiNavigationComponent implements OnInit {

    public tournaments: Tournament[] = [];
    public tournamentsOpen = false;

    constructor(private elementRef: ElementRef, private tournamentService: TournamentService) {
    }

    public ngOnInit(): void {
        this.tournamentService.getTournaments().subscribe(
            (tournaments: Tournament[]) => {
                this.tournaments = tournaments;
            }
        );
    }

    @HostListener('document:click', ['$event'])
    public onClick(event) {
        if (!this.elementRef.nativeElement.querySelector('#trnmnts').contains(event.target)) {
            if (this.tournamentsOpen) {
                this.tournamentsOpen = false;
            }
        }
    }

}
