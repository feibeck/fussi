import { async, TestBed, ComponentFixture, fakeAsync, inject, tick } from '@angular/core/testing';
import { Observable } from 'rxjs';
import { PlayerService } from './player.service';
import { Player } from './player.model';
import { Router, ActivatedRoute } from '@angular/router';
import { PointLogService } from './point-log.service';
import { PlayerDetailComponent } from './player-detail.component';
import { PointLog } from './point-log.model';
import { PlayerLoadError } from './player-load-error.model';
import { SharedModule } from '../shared';

const player = new Player(1, 'Foo', 0, 0);

const pointLog = [
    new PointLog(10, 20, 12, 18, 90, 10, { player1: {id: 2}, player2: {id: 3}}),
    new PointLog(10, 20, 12, 18, 90, 10, { player1: {id: 2}, player2: {id: 3}}),
];

/* tslint:disable:max-classes-per-file */
/* Don't want to have the stubs in extra files… */

class PlayerServiceStub {
    public getPlayer(id: number) {
        // to be spyed on
    }
}

class RouterStub {
    public navigate(target: any, options?: any) {
        // to be spyed on
    }
}

class PointLogServiceStub {
    public getPointLog(id: number) {
        //  to be spyed on
    }
}

describe('PlayerDetailComponent', () => {

    let fixture: ComponentFixture<PlayerDetailComponent>;
    let component: PlayerDetailComponent;

    beforeEach(async(() => {

        TestBed.configureTestingModule({
            declarations: [
                PlayerDetailComponent
            ],
            imports: [
                SharedModule
            ],
            providers: [
                {
                    provide: PlayerService,
                    useClass: PlayerServiceStub
                },
                {
                    provide: PointLogService,
                    useClass: PointLogServiceStub
                },
                {
                    provide: Router,
                    useClass: RouterStub
                },
                {
                    provide: ActivatedRoute,
                    useFactory: () => {
                        return {
                            params: Observable.of({id: 1})
                        };
                    }
                }
            ]
        }).compileComponents();

    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(PlayerDetailComponent);
        component = fixture.componentInstance;
    });

    it('should be readly initialized', () => {
        expect(fixture).toBeDefined();
        expect(component).toBeDefined();
    });

    it('should load player and point log',
        fakeAsync(inject([PlayerService, PointLogService],
            (playerService: PlayerService, pointLogService: PointLogService) => {

        spyOn(playerService, 'getPlayer').and.returnValue(Observable.of(player));
        spyOn(pointLogService, 'getPointLog').and.returnValue(Observable.of(pointLog));

        fixture.detectChanges();
        tick();

        expect(component.player).toBe(player);
        expect(component.pointLog).toBe(pointLog);

    })));

    it('shoud redirect to not-found page on unknown player',
        fakeAsync(inject([PlayerService, PointLogService, Router],
            (playerService: PlayerService, pointLogService: PointLogService, router: Router) => {

        spyOn(playerService, 'getPlayer').and.returnValue(
            Observable.throw(PlayerLoadError.createNotExistsError())
        );
        spyOn(pointLogService, 'getPointLog').and.returnValue(
            Observable.throw(PlayerLoadError.createGeneralError('foo'))
        );
        spyOn(router, 'navigate');

        fixture.detectChanges();
        tick();

        expect(router.navigate).toHaveBeenCalledWith(['/not-found'], { skipLocationChange: true });

    })));

    it('shoud redirect to error page on other error',
        fakeAsync(inject([PlayerService, PointLogService, Router],
            (playerService: PlayerService, pointLogService: PointLogService, router: Router) => {

        spyOn(playerService, 'getPlayer').and.returnValue(
            Observable.throw(PlayerLoadError.createGeneralError('foo'))
        );
        spyOn(pointLogService, 'getPointLog').and.returnValue(
            Observable.throw(PlayerLoadError.createGeneralError('foo'))
        );
        spyOn(router, 'navigate');

        fixture.detectChanges();
        tick();

        expect(router.navigate).toHaveBeenCalledWith(['/error'], { skipLocationChange: true });

    })));

    it('shoud ignore errors of the point log service',
        fakeAsync(inject([PlayerService, PointLogService, Router],
            (playerService: PlayerService, pointLogService: PointLogService, router: Router) => {

        spyOn(playerService, 'getPlayer').and.returnValue(
            Observable.of(player)
        );
        spyOn(pointLogService, 'getPointLog').and.returnValue(
            Observable.throw(PlayerLoadError.createGeneralError('foo'))
        );

        fixture.detectChanges();
        tick();

        expect(component.pointLog).toBeUndefined();

    })));

});
