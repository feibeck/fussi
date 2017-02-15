import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { PlayerService } from './player.service';
import { Player } from './player.model';
import { PlayerSaveError } from './player-save-error.model';
import { Observable } from 'rxjs';

import 'rxjs/add/operator/switchMap';

@Component({
    selector: 'player-edit',
    templateUrl: './player-edit.component.html'
})
export class PlayerEditComponent implements OnInit {

    public player: Player;

    public playerForm: FormGroup;

    constructor(
        private playerService: PlayerService,
        private route: ActivatedRoute,
        private router: Router,
        private formBuilder: FormBuilder) {
        this.createForm();
    }

    public ngOnInit(): void {
        this.route.params
            .switchMap((params: Params) => {
                if (params['id']) {
                    return this.playerService.getPlayer(+params['id']);
                } else {
                    let newPlayer = {
                        id: null,
                        name: null,
                        points: null,
                        matchCount: null
                    };
                    return Observable.of(newPlayer);
                }
            })
            .subscribe((player) => this.setPlayer(player));
    }

    public onSubmit() {
        this.playerService.save(this.prepareSavePlayer()).subscribe(
            (player: Player) => {
                this.router.navigate(['/players']);
            },
            (error: PlayerSaveError) => {
                if (error.isValidationError()) {
                    this.setValidationMessages(error.getValidationMessages());
                } else {
                    alert(error.getMessage());
                }
            }
        );
    }

    private setValidationMessages(messages: Array<{field: string, message: string}>) {
        for (let message of messages) {
            this.playerForm.controls[message.field].setErrors({remote: message.message});
        }
    }

    private prepareSavePlayer(): Player {
        const formModel = this.playerForm.value;

        return {
            id: this.player.id,
            name: formModel.name as string,
            points: this.player.points,
            matchCount: this.player.matchCount
        };
    }

    private createForm() {
        this.playerForm = this.formBuilder.group({
            name: ['', Validators.required ],
        });
    }

    private setPlayer(player: Player) {
        this.player = player;
        this.playerForm.setValue({
            name: player.name
        });
    }

}
