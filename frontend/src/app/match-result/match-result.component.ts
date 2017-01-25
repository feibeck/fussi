import {Component, Input} from '@angular/core';

@Component({
    selector: 'match-result',
    templateUrl: './match-result.component.html'
})
export class MatchResultComponent {

    @Input() match;

}
