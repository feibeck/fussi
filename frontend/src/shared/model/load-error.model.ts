export class LoadError {

    public static defaultMessage = 'An error occured while loading data.';

    public static defaultNotExistsMessage = 'Requested entity does not exist.';

    public static NOT_EXISTS = 'not_exists';

    public static GENERAL_ERROR = 'general_error';

    public static createNotExistsError(message: string = LoadError.defaultNotExistsMessage) {
        return new LoadError(LoadError.NOT_EXISTS, message);
    }

    public static createGeneralError(message: string = LoadError.defaultMessage) {
        return new LoadError(LoadError.GENERAL_ERROR, message);
    }

    public type: string;

    public message: string;

    constructor(type: string, message: string) {
        this.type = type;
        this.message = message;
    }

    public isNotExistsError(): boolean {
        return this.type === LoadError.NOT_EXISTS;
    }

    public isGeneralError(): boolean {
        return this.type === LoadError.GENERAL_ERROR;
    }

    public getMessage(): string {
        return this.message;
    }

}
