export class PlayerSaveError {

    public static defaultMessage: string = 'Something went wrong. Please try again!';

    private message: string;

    private validationError: boolean = false;

    private validationMessages: Array<{field: string, message: string}> = [];

    constructor(message: string = PlayerSaveError.defaultMessage, validationError: boolean = false) {
        this.message = message;
        this.validationError = validationError;
    }

    public getMessage(): string {
        return this.message;
    }

    public isValidationError(): boolean {
        return this.validationError;
    }

    public setValidationMessages(messages: Array<{field: string, message: string}>) {
        this.validationMessages = messages;
    }

    public getValidationMessages(): Array<{field: string, message: string}> {
        return this.validationMessages;
    }

}
