import { platformBrowser } from '@angular/platform-browser';
import { decorateModuleRef } from './environment';
import { AppModuleNgFactory } from '../compiled/src/app/app.module.ngfactory';

export function main(): Promise<any> {
  return platformBrowser()
    .bootstrapModuleFactory(AppModuleNgFactory)
    .then(decorateModuleRef)
    .catch((err) => console.error(err));
}

export function bootstrapDomReady() {
  document.addEventListener('DOMContentLoaded', main);
}

bootstrapDomReady();
