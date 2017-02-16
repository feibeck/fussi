import { Component, Input } from '@angular/core';

@Component({
    selector: 'match-player',
    templateUrl: './match-player.component.html'
})
export class MatchPlayerComponent {

    @Input() public match;
    @Input() public pointLog;

}
