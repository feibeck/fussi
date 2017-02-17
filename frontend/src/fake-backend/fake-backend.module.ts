import { NgModule } from '@angular/core';
import { fakeBackendProvider } from './FakeBackendProvider';
import { BaseRequestOptions } from '@angular/http';
import { MockBackend } from '@angular/http/testing';

@NgModule({
    bootstrap: [ ],
    declarations: [ ],
    imports: [
    ],
    exports: [ ],
    providers: [
        fakeBackendProvider,
        BaseRequestOptions,
        MockBackend
    ]
})
export class FakeBackendModule {
}
