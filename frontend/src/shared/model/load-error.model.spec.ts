import { LoadError } from './load-error.model';

describe('LoadError', () => {

    describe('createNotExistsError()', () => {

        it('should use default error message', () => {
            const error = LoadError.createNotExistsError();
            expect(error.isNotExistsError()).toBeTruthy();
            expect(error.isGeneralError()).toBeFalsy();
            expect(error.getMessage()).toBe(LoadError.defaultNotExistsMessage);
        });

        it('can use custom error message', () => {
            const error = LoadError.createNotExistsError('foo');
            expect(error.isNotExistsError()).toBeTruthy();
            expect(error.isGeneralError()).toBeFalsy();
            expect(error.getMessage()).toBe('foo');
        });

    });

    describe('createGeneralError()', () => {

        it('should use default error message', () => {
            const error = LoadError.createGeneralError();
            expect(error.isNotExistsError()).toBeFalsy();
            expect(error.isGeneralError()).toBeTruthy();
            expect(error.getMessage()).toBe(LoadError.defaultMessage);
        });

        it('can use custom error message', () => {
            const error = LoadError.createGeneralError('foo');
            expect(error.isNotExistsError()).toBeFalsy();
            expect(error.isGeneralError()).toBeTruthy();
            expect(error.getMessage()).toBe('foo');
        });

    });

});
