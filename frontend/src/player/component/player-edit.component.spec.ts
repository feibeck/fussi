import { async, TestBed, ComponentFixture, inject, fakeAsync, tick } from '@angular/core/testing';
import { ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { PlayerService } from '../service/player.service';
import { PlayerEditComponent } from './player-edit.component';
import { Player } from '../model/player.model';
import { PlayerSaveError } from '../model/player-save-error.model';

/* tslint:disable:max-classes-per-file */
/* Don't want to have the stubs in extra files… */

class PlayerServiceStub {

    public getPlayer(id: number): Observable<Player> {
        return Observable.of(new Player(1, 'Foo', 0, 0));
    }

    public save(player: Player): Observable<Player> {
        return Observable.of(new Player(1, 'Foo', 0, 0));
    }

}

class RouterStub {

    public navigate(target: any) {
        // to be spyed on
    }

}

describe('PlayerEditComponent', () => {

    let fixture: ComponentFixture<PlayerEditComponent>;
    let component: PlayerEditComponent;

    beforeEach(async(() => {

        TestBed.configureTestingModule({
            declarations: [ PlayerEditComponent ],
            imports: [
                ReactiveFormsModule
            ],
            providers: [
                {
                    provide: PlayerService,
                    useClass: PlayerServiceStub
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
        fixture = TestBed.createComponent(PlayerEditComponent);
        component = fixture.componentInstance;
    });

    it(`should be readly initialized`, () => {
        expect(fixture).toBeDefined();
        expect(component).toBeDefined();
    });

    describe('when editing player', () => {

        beforeEach(() => {
            fixture.detectChanges();
        });

        it('the name field is populated with the players name', fakeAsync(() => {

            tick();
            fixture.detectChanges();

            let inputElement = fixture.nativeElement.querySelector('#name');

            expect(inputElement.value).toBe('Foo');

        }));

        it('should redirect after successful save',
            fakeAsync(inject([Router, PlayerService], (router: Router, playerService: PlayerService) => {

            spyOn(router, 'navigate');
            spyOn(playerService, 'save').and.callThrough();

            component.onSubmit();

            tick();
            fixture.detectChanges();

            expect(playerService.save).toHaveBeenCalledWith(new Player(1, 'Foo', 0, 0));
            expect(router.navigate).toHaveBeenCalledWith(['/player/list']);

        })));

        it('should display message in case of general error',
            fakeAsync(inject([PlayerService], (playerService: PlayerService) => {

            spyOn(playerService, 'save').and.returnValue(
                Observable.throw(new PlayerSaveError())
            );

            component.onSubmit();

            tick();
            fixture.detectChanges();

            expect(playerService.save).toHaveBeenCalledWith(new Player(1, 'Foo', 0, 0));
            expect(component.error).toBeTruthy();
            expect(component.errorMessage).toBe(PlayerSaveError.defaultMessage);

        })));

        it('should display validation message',
            fakeAsync(inject([PlayerService], (playerService: PlayerService) => {

            let playerSaveError = new PlayerSaveError('', true);
            playerSaveError.setValidationMessages([{field: 'name', message: 'Foobar!'}]);

            spyOn(playerService, 'save').and.returnValue(
                Observable.throw(playerSaveError)
            );

            component.onSubmit();

            tick();
            fixture.detectChanges();

            expect(playerService.save).toHaveBeenCalledWith(new Player(1, 'Foo', 0, 0));
            expect(component.playerForm.controls['name'].errors['remote']).toBe('Foobar!');

        })));

    });

    describe('when creating new player', () => {

        it('the name field is empty',
            fakeAsync(inject([ActivatedRoute], (activatedRoute) => {

            activatedRoute.params = Observable.of({});
            fixture.detectChanges();

            tick();
            fixture.detectChanges();

            let nativeElement = fixture.nativeElement;
            expect(nativeElement.querySelector('#name').value).toBe('');

        })));

        it('should redirect after successful save',
            fakeAsync(inject([Router, PlayerService, ActivatedRoute],
                (router: Router, playerService: PlayerService, activatedRoute) => {

            spyOn(router, 'navigate');
            spyOn(playerService, 'save').and.callThrough();

            activatedRoute.params = Observable.of({});
            fixture.detectChanges();

            let inputElement = fixture.nativeElement.querySelector('#name');
            inputElement.value = 'Foo';
            inputElement.dispatchEvent(new Event('input'));

            fixture.detectChanges();

            component.onSubmit();

            tick();
            fixture.detectChanges();

            expect(playerService.save).toHaveBeenCalledWith(new Player(null, 'Foo', 0, 0));
            expect(router.navigate).toHaveBeenCalledWith(['/player/list']);

        })));

    });

});
