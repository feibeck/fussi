import { Component } from '@angular/core';
import { async, TestBed, ComponentFixture, inject, fakeAsync, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Observable } from 'rxjs';
import { PlayerService } from '../service/player.service';
import { Player } from '../model/player.model';
import { PlayerListComponent } from './player-list.component';
import { LoadError } from '../../shared/model/load-error.model';

const playerList = [new Player(1, 'Foo', 0, 0), new Player(2, 'Bar', 0, 0)];

/* tslint:disable:max-classes-per-file */
/* Don't want to have the stubs in extra files… */

class PlayerServiceStub {
    public getPlayerList() {
        // to be spyed on
    }
}

@Component({
    selector: 'dummy',
    template: ''
})
class DummyComponent {
}

describe('PlayerListComponent', () => {

    let fixture: ComponentFixture<PlayerListComponent>;
    let component: PlayerListComponent;

    beforeEach(async(() => {

        TestBed.configureTestingModule({
            declarations: [
                PlayerListComponent,
                DummyComponent
            ],
            imports: [
                RouterTestingModule.withRoutes([
                    { path: 'player/show/:id', component: DummyComponent },
                    { path: 'player/edit/:id', component: DummyComponent },
                    { path: 'player/new', component: DummyComponent },
                ])
            ],
            providers: [
                {
                    provide: PlayerService,
                    useClass: PlayerServiceStub
                }
            ]
        }).compileComponents();

    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(PlayerListComponent);
        component = fixture.componentInstance;
    });

    it('should be readly initialized', () => {
        expect(fixture).toBeDefined();
        expect(component).toBeDefined();
    });

    it('should load players',
        fakeAsync(inject([PlayerService], (playerService: PlayerService) => {

        spyOn(playerService, 'getPlayerList').and.returnValue(Observable.of(playerList));

        fixture.detectChanges();
        tick();

        expect(playerService.getPlayerList).toHaveBeenCalled();
        expect(component.players).toBe(playerList);

    })));

    it('should handle errors',
        fakeAsync(inject([PlayerService], (playerService: PlayerService) => {

        spyOn(playerService, 'getPlayerList').and.returnValue(
            Observable.throw(LoadError.createGeneralError('foo'))
        );

        fixture.detectChanges();
        tick();

        expect(playerService.getPlayerList).toHaveBeenCalled();
        expect(component.players).toEqual([]);
        expect(component.error).toBeTruthy();

    })));

});
