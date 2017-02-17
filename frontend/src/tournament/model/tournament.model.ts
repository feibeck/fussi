import { JsonTournament } from './json-tournament.model';

export class Tournament {

    public static fromJsonTournament(jsonTournament: JsonTournament) {
        return new Tournament(jsonTournament.name);
    }

    private _name;

    constructor(name) {
        this._name = name;
    }

    get name() {
        return this._name;
    }

}
