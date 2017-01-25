import { Component, OnInit, ViewEncapsulation } from '@angular/core';

@Component({
    selector: 'fussi-main-navigation',
    encapsulation: ViewEncapsulation.None,
    template: `
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Fußi</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li class=""><a href="#">Home</a></li>
                    <li class="dropdown">
                        <a id="trnmnts" class="dropdown-toggle" data-toggle="dropdown" href="#">Tournaments <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" tabindex="-1" role="menuitem">Tournaments</a></li>
                            <li class="divider"></li>
                            <!-- List of tournaments coming here -->
                        </ul>
                    </li>
                    <li class=""><a [routerLink]=" ['./players'] " routerLinkActive="active">Players</a></li>
                </ul>
            </div>
        </nav>
  `
})
export class FussiNavigation {

}
