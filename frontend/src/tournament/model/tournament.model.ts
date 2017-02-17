import { JsonTournament } from './json-tournament.model';

export class Tournament {

    public static fromJsonTournament(jsonTournament: JsonTournament) {
        return new Tournament(
            jsonTournament.id,
            jsonTournament.name,
            jsonTournament.type,
            jsonTournament.active
        );
    }

    private _id: number;

    private _name: string;

    private _type: string;

    private _active: boolean;

    constructor(id: number, name: string, type: string, active: boolean) {
        this._id = id;
        this._name = name;
        this._type = type;
        this._active = active;
    }

    get id(): number {
        return this._id;
    }

    get name(): string {
        return this._name;
    }

    get type(): string {
        return this._type;
    }

    get active(): boolean {
        return this._active;
    }

}
