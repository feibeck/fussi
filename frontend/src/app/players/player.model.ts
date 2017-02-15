import { JsonPlayer } from './json-player.model';

export class Player {

    public static fromJsonPlayer(jsonPlayer: JsonPlayer): Player {
        return new Player(
            jsonPlayer.id,
            jsonPlayer.name,
            jsonPlayer.points,
            jsonPlayer.matchCount
        );
    }

    private _id: number;

    private _name: string;

    private _points: number;

    private _matchCount: number;

    constructor(id: number, name: string, points: number, matchCount: number) {
        this._id = id;
        this._name = name;
        this._points = points;
        this._matchCount = matchCount;
    }

    get id(): number {
        return this._id;
    }

    get name(): string {
        return this._name;
    }

    set name(value: string) {
        this._name = value;
    }

    get points(): number {
        return this._points;
    }

    get matchCount(): number {
        return this._matchCount;
    }

    public toJsonPlayer(): JsonPlayer {
        return {
            id: this._id,
            name: this._name,
            points: this._points,
            matchCount: this._matchCount
        };
    }

    public clone(): Player {
        return new Player(
            this._id,
            this._name,
            this._points,
            this._matchCount
        );
    }

}
