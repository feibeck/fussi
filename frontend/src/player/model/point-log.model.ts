import { JsonPointLog } from './json-point-log.model';

export class PointLog {

    public static fromJsonPointLog(jsonPointLog: JsonPointLog) {
        return new PointLog(
            jsonPointLog.currentPoints1,
            jsonPointLog.currentPoints2,
            jsonPointLog.newPoints1,
            jsonPointLog.newPoints2,
            jsonPointLog.chance1,
            jsonPointLog.chance2,
            jsonPointLog.match
        );
    }

    private _currentPoints1: number;

    private _currentPoints2: number;

    private _newPoints1: number;

    private _newPoints2: number;

    private _chance1: number;

    private _chance2: number;

    private _match: any;

    constructor(currentPoints1: number,
                currentPoints2: number,
                newPoints1: number,
                newPoints2: number,
                chance1: number,
                chance2: number,
                match: any
    ) {
        this._currentPoints1 = currentPoints1;
        this._currentPoints2 = currentPoints2;
        this._newPoints1 = newPoints1;
        this._newPoints2 = newPoints2;
        this._chance1 = chance1;
        this._chance2 = chance2;
        this._match = match;
    }

    get currentPoints1(): number {
        return this._currentPoints1;
    }

    get currentPoints2(): number {
        return this._currentPoints2;
    }

    get newPoints1(): number {
        return this._newPoints1;
    }

    get newPoints2(): number {
        return this._newPoints2;
    }

    get chance1(): number {
        return this._chance1;
    }

    get chance2(): number {
        return this._chance2;
    }

    get match(): any {
        return this._match;
    }

    public playersChance(playerId: number) {
        if (this.match.player1.id === playerId) {
            return this.chance1;
        } else {
            return this.chance2;
        }
    }

    public playersPoints(playerId: number) {
        if (this.match.player1.id === playerId) {
            return this.newPoints1;
        } else {
            return this.newPoints2;
        }
    }

}
