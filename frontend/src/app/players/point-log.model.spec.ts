import { JsonPointLog } from './json-point-log.model';
import { PointLog } from './point-log.model';

describe('PointLog', () => {

    it('fromJsonPointLog()', () =>  {

        const jsonPointLog: JsonPointLog = {
            currentPoints1: 10,
            currentPoints2: 20,
            newPoints1: 12,
            newPoints2: 18,
            chance1: 90,
            chance2: 10,
            match: { }
        };

        const pointLog = PointLog.fromJsonPointLog(jsonPointLog);

        expect(pointLog.currentPoints1).toBe(10);
        expect(pointLog.currentPoints2).toBe(20);
        expect(pointLog.newPoints1).toBe(12);
        expect(pointLog.newPoints2).toBe(18);
        expect(pointLog.chance1).toBe(90);
        expect(pointLog.chance2).toBe(10);
        expect(pointLog.match).toEqual({});

    });

    describe('playersChance()', () => {

        const log = new PointLog(10, 20, 12, 18, 90, 10, { player1: {id: 2}, player2: {id: 3}});

        it('can find player one\'s chance', () => {
            expect(log.playersChance(2)).toBe(90);
        });

        it('can find player two\'s chance', () => {
            expect(log.playersChance(3)).toBe(10);
        });

    });

    describe('playersPoints()', () => {

        const log = new PointLog(10, 20, 12, 18, 90, 10, { player1: {id: 2}, player2: {id: 3}});

        it('can find player one\'s points', () => {
            expect(log.playersPoints(2)).toBe(12);
        });

        it('can find player two\'s points', () => {
            expect(log.playersPoints(3)).toBe(18);
        });

    });

});
