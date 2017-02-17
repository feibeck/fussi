import { Injectable } from '@angular/core';

@Injectable()
export class FakeBackendConfig {

    private config = {};

    private defaultConfig = {
        nextRequestError: false
    };

    constructor() {
        this.config = JSON.parse(localStorage.getItem('fake-backend-config')) || this.defaultConfig;
    }

    public set(key, value) {
        this.config['key'] = value;
        localStorage.setItem('fake-backend-config', JSON.stringify(this.config));
    }

    public isAndReset(key) {
        if (this.config[key]) {
            this.set(key, false);
            return true;
        }
        return false;
    }

}
