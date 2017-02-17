import { TestBed, inject } from '@angular/core/testing';
import { MockBackend } from '@angular/http/testing';
import { HttpModule, BaseRequestOptions, Http, Response, ResponseOptions } from '@angular/http';
import { PointLogService } from './point-log.service';
import { JsonPointLog } from '../model/json-point-log.model';
import { PointLog } from '../model/point-log.model';
import { LoadError } from '../../shared/model/load-error.model';

describe('PointLogService', () => {

    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [HttpModule],
            providers: [
                PointLogService,
                MockBackend,
                BaseRequestOptions,
                {
                    provide: Http,
                    useFactory: (mockBackend, options) => {
                        return new Http(mockBackend, options);
                    },
                    deps: [MockBackend, BaseRequestOptions]
                }
            ]
        });
    });

    describe('getPlayer()', () => {

        it('returns a pointlog list', inject([PointLogService, MockBackend], (pointLogService, mockBackend) => {

            const jsonPointLogList: JsonPointLog[] = [
                {
                    currentPoints1: 10,
                    currentPoints2: 20,
                    newPoints1: 12,
                    newPoints2: 18,
                    chance1: 90,
                    chance2: 10,
                    match: { }
                },
                {
                    currentPoints1: 12,
                    currentPoints2: 18,
                    newPoints1: 14,
                    newPoints2: 16,
                    chance1: 85,
                    chance2: 15,
                    match: { }
                }
            ];

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(jsonPointLogList)
                })));
            });

            pointLogService.getPointLog(1).subscribe((pointLogList: PointLog[]) => {
                expect(pointLogList.length).toBe(2);
            });

        }));

        it('handles server error', inject([PointLogService, MockBackend], (pointLogService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500
                })));
            });

            pointLogService.getPointLog(1).subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                }
            );
        }));

        it('handles not found error', inject([PointLogService, MockBackend], (pointLogService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 404
                })));
            });

            pointLogService.getPointLog(1).subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                }
            );
        }));

        it('handles invalid json', inject([PointLogService, MockBackend], (pointLogService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    status: 200,
                    body: '{id:'
                })));
            });

            pointLogService.getPointLog(1).subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                }
            );
        }));

    });

});
