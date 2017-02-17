import { Component } from '@angular/core';
import { async, TestBed, ComponentFixture, inject, fakeAsync, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Observable } from 'rxjs';
import { LoadError } from '../../shared/model/load-error.model';
import { TournamentListComponent } from './tournament-list.component';
import { TournamentService } from '../service/tournament.service';
import { Tournament } from '../model/tournament.model';

const tournamentList = [new Tournament(1, 'Foo', 'League', true), new Tournament(2, 'Bar', 'Tournament', true)];

/* tslint:disable:max-classes-per-file */
/* Don't want to have the stubs in extra files… */

class TournamentServiceStub {
    public getTournaments() {
        // to be spyed on
    }
}

@Component({
    selector: 'dummy',
    template: ''
})
class DummyComponent {
}

describe('TournamentListComponent', () => {

    let fixture: ComponentFixture<TournamentListComponent>;
    let component: TournamentListComponent;

    beforeEach(async(() => {

        TestBed.configureTestingModule({
            declarations: [
                TournamentListComponent,
                DummyComponent
            ],
            imports: [
                RouterTestingModule.withRoutes([
                    { path: 'tournament/show/:id', component: DummyComponent }
                ])
            ],
            providers: [
                {
                    provide: TournamentService,
                    useClass: TournamentServiceStub
                }
            ]
        }).compileComponents();

    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(TournamentListComponent);
        component = fixture.componentInstance;
    });

    it('should be readly initialized', () => {
        expect(fixture).toBeDefined();
        expect(component).toBeDefined();
    });

    it('should load tournaments',
        fakeAsync(inject([TournamentService], (tournamentService: TournamentService) => {

        spyOn(tournamentService, 'getTournaments').and.returnValue(Observable.of(tournamentList));

        fixture.detectChanges();
        tick();

        expect(tournamentService.getTournaments).toHaveBeenCalled();
        expect(component.tournaments).toBe(tournamentList);

    })));

    it('should handle errors',
        fakeAsync(inject([TournamentService], (tournamentService: TournamentService) => {

        spyOn(tournamentService, 'getTournaments').and.returnValue(
            Observable.throw(LoadError.createGeneralError('foo'))
        );

        fixture.detectChanges();
        tick();

        expect(tournamentService.getTournaments).toHaveBeenCalled();
        expect(component.tournaments).toEqual([]);
        expect(component.error).toBeTruthy();

    })));

});
