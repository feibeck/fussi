import { Player } from './player.model';
import { JsonPlayer } from './json-player.model';

describe('Player', () => {

    describe('clone()', () => {

        it('clones a player', () => {
            const player = new Player(12, 'Foo', 345, 12);
            const clone = player.clone();

            player.name = 'Bar';

            expect(clone.id).toBe(12);
            expect(clone.name).toBe('Foo');
            expect(clone.points).toBe(345);
            expect(clone.matchCount).toBe(12);
        });

    });

    describe('toJsonPlayer()', () => {

        it('returns object with all fields set', () => {
            const player = new Player(12, 'Foo', 345, 12);
            const jsonPlayer = player.toJsonPlayer();

            expect(jsonPlayer.id).toBe(12);
            expect(jsonPlayer.name).toBe('Foo');
            expect(jsonPlayer.points).toBe(345);
            expect(jsonPlayer.matchCount).toBe(12);
        });

    });

    describe('fromJsonPlayer()', () => {

        it('creates Player from JsonPlayer', () => {
            const jsonPlayer: JsonPlayer = {
                id: 12,
                name: 'Foo',
                points: 345,
                matchCount: 12
            };

            const player = Player.fromJsonPlayer(jsonPlayer);

            expect(player.id).toBe(12);
            expect(player.name).toBe('Foo');
            expect(player.points).toBe(345);
            expect(player.matchCount).toBe(12);
        });

    });

});
