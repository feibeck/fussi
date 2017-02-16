export class PlayerLoadError {

    public static listLoadingError = 'Could not load player list';

    public static playerLoadingError = 'Could not load player';

    public static pointlogLoadingError = 'Could not load player point log';

    public static playerNotExistsError = 'Player does not exist';

    public static NOT_EXISTS = 'not_exists';

    public static GENERAL_ERROR = 'general_error';

    public static createNotExistsError() {
        return new PlayerLoadError(PlayerLoadError.NOT_EXISTS, PlayerLoadError.playerNotExistsError);
    }

    public static createGeneralError(message) {
        return new PlayerLoadError(PlayerLoadError.GENERAL_ERROR, message);
    }

    public type: string;

    public message: string;

    constructor(type: string, message: string) {
        this.type = type;
        this.message = message;
    }

    public isNotExistsError(): boolean {
        return this.type === PlayerLoadError.NOT_EXISTS;
    }

    public isGeneralError(): boolean {
        return this.type === PlayerLoadError.GENERAL_ERROR;
    }

    public getMessage(): string {
        return this.message;
    }

}
