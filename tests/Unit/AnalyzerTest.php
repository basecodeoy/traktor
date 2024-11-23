<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Traktor\Analyzers\Analyzer;
use BaseCodeOy\Traktor\Values\TrackingNumber;

it('can analyze a tracking number that is valid', function (string $carrier, string $trackingNumber): void {
    $result = (new Analyzer())->analyze($trackingNumber);

    expect($result)->toBeInstanceOf(TrackingNumber::class);
    expect($result->carrier->name)->toBe($carrier);
})->with([
    ['Amazon', 'TBA000000000000'],
    ['Amazon', 'TBA010000000000'],
    ['Amazon', 'TBA 000000000000'],
    ['Amazon', 'TBA502887274000'],
    ['Amazon', 'C1004444443'],
    ['Amazon', 'C1004444444'],
    ['Canada Post', '0073938000549297'],
    ['Canada Post', '7035114477138472'],
    ['Canada Post', '4002847016405018'],
    ['DHL', '3318810025'],
    ['DHL', '73891051146'],
    ['DHL', '8487135506'],
    ['DHL', '1099255990'],
    ['DHL', '3821724944'],
    ['DHL', '3318810036'],
    ['DHL', '3318810014'],
    ['DHL', 'JJD0099999999'],
    ['DHL', 'JVGL0999999990'],
    ['DHL', 'GM2951173225174494'],
    ['DHL', 'GM 2 9 5 117 32 25 1 7 44 9 4'],
    ['DHL', 'GM295117494011169042'],
    ['DPD', '00 81827 0998 0000 0200 33 350 276 C'],
    ['DPD', '0081 827 0998 0000 0200 45 327 276 N'],
    ['DPD', '09 9800 0002 0033 F'],
    ['DPD', '0998 0000 0200 34D'],
    // Fedex
    ['FedEx', '986578788855'],
    ['FedEx', '477179081230'],
    ['FedEx', '799531274483'],
    ['FedEx', '790535312317'],
    ['FedEx', ' 7 9 0 5 3 5 3 1 2 3 1 7 '],
    ['FedEx', '974367662710'],
    ['FedEx', '1001921334250001000300779017972697'],
    ['FedEx', '1001921380360001000300639585804382'],
    ['FedEx', '1001901781990001000300617767839437'],
    ['FedEx', ' 1 0 0 1 9 0 1 7 8 1 9 9 0 0 0 1 0 0 0 3 0 0 6 1 7 7 6 7 8 3 9 4 3 7 '],
    ['FedEx', '1002297871540001000300790695517286'],
    ['FedEx', '1027590111820004833500785458233610'],
    ['FedEx', '61299998820821171811'],
    ['FedEx', '9261292700768711948021'],
    ['FedEx', '420 11213 92 6129098349792366623 8'],
    ['FedEx', '92 6129098349792366623 8'],
    ['FedEx', '6129098349792366623 8'],
    ['FedEx', '0414 4176 0228 964'],
    ['FedEx', '5682 8361 0012 000'],
    ['FedEx', ' 5 6 8 2   8 3 6 1   0 0 1 2   0 0 0 '],
    ['FedEx', '5682 8361 0012 734'],
    ['FedEx', '00 0123 4500 0000 0027'],
    ['FedEx', ' 0 0   0 1 2 3   4 5 0 0   0 0 0 0   0 0 2 7 '],
    ['FedEx', '9611020987654312345672'],
    ['FedEx', ' 9 6 1 1 0 2 0 9 8 7 6 5 4 3 1 2 3 4 5 6 7 2 '],
    ['FedEx', '9622001900000000000000776632517510'],
    ['FedEx', '9622001560000000000000794808390594'],
    ['FedEx', '9622001560001234567100794808390594'],
    ['FedEx', ' 9 6 2 2 0 0 1 5 6 0 0 0 1 2 3 4 5 6 7 1 0 0 7 9 4 8 0 8 3 9 0 5 9 4 '],
    ['FedEx', '9632001560123456789900794808390594'],
    ['Landmark Global LTN', 'LTN74207623N1'],
    ['Landmark Global LTN', 'LTN74209518N1'],
    ['Landmark Global LTN', 'LTN74224021N1'],
    ['LaserShip', 'LX17635036'],
    ['LaserShip', 'LX 176 35035'],
    ['LaserShip', 'LX17635034'],
    ['LaserShip', 'LI 129 79072'],
    ['LaserShip', 'LI12976442'],
    ['LaserShip', 'LA28376237'],
    ['LaserShip', 'LA28372694'],
    ['LaserShip', 'LH13830790'],
    ['LaserShip', 'LH13816137'],
    ['LaserShip', 'LH13820469'],
    ['LaserShip', 'LH13831034'],
    ['LaserShip', 'LH13821737'],
    ['LaserShip', 'LH13820881'],
    ['LaserShip', 'LH13820881'],
    ['LaserShip', 'LH13812209'],
    ['LaserShip', 'LH13800911'],
    ['LaserShip', 'LH13795254'],
    ['LaserShip', 'LE10917377'],
    ['LaserShip', 'LE10913900'],
    ['LaserShip', 'LE10913753'],
    ['LaserShip', 'LN30083672'],
    ['LaserShip', '1LS717793482164'],
    ['LaserShip', '1LS724505321754'],
    ['LaserShip', '1LS720000000000'],
    ['LaserShip', ' 1 L S 7 2 0 0 0 0 0 0 0 0 0 0 '],
    ['LaserShip', '1LS7119013618127-1'],
    ['LaserShip', ' 1 L S 7 1 1 9 0 1 3 6 1 8 1 2 7 - 1 '],
    ['OnTrac', 'C11031500001879'],
    ['OnTrac', 'C 110 31 500 00187 9'],
    ['OnTrac', 'C10999911320231'],
    ['OnTrac', 'C11121552953069'],
    ['OnTrac', 'C11121553156000'],
    ['OnTrac', 'C11121552829468'],
    ['OnTrac', 'D10011354453707'],
    ['OnTrac', 'D10011345983010'],
    ['OnTrac', 'D 100 113 459 830 10'],
    ['OnTrac', 'D10011342332145'],
    ['S10 International Standard', 'RB123456785GB'],
    ['S10 International Standard', 'RB123456785US'],
    ['S10 International Standard', 'RB123456785CV'],
    ['S10 International Standard', 'RB123456785CF'],
    ['UPS', '1Z5R89390357567127'],
    ['UPS', '1Z879E930346834440'],
    ['UPS', '1Z410E7W0392751591'],
    ['UPS', '1Z8V92A70367203024'],
    ['UPS', ' 1 Z 8 V 9 2 A 7 0 3 6 7 2 0 3 0 2 4 '],
    ['UPS', '1ZXX3150YW44070023'],
    ['UPS', 'K1506235620'],
    ['UPS', 'K 150 623 562 0'],
    ['UPS', 'K2479825491'],
    ['UPS', 'J4603636537'],
    ['UPS', 'V0490119172'],
    ['UPS', 'V0431105627'],
    ['United States Postal Service', '0307 1790 0005 2348 3741'],
    ['United States Postal Service', ' 0 3 0 7   1 7 9 0   0 0 0 5   2 3 4 8   3 7 4 1 '],
    ['United States Postal Service', '7112 3456 7891 2345 6787'],
    ['United States Postal Service', '4201002334249200190132607600833457'],
    ['United States Postal Service', '4201028200009261290113185417468510'],
    ['United States Postal Service', ' 4 2 0 1 0 2 8 2 0 0 0 0 9 2 6 1 2 9 0 1 1 3 1 8 5 4 1 7 4 6 8 5 1 0 '],
    ['United States Postal Service', '420 22153 9101026837331000039521'],
    ['United States Postal Service', '7196 9010 7560 0307 7385'],
    ['United States Postal Service', '9505 5110 6960 5048 6006 24'],
    ['United States Postal Service', '9101 1234 5678 9000 0000 13'],
    ['United States Postal Service', '92748931507708513018050063'],
    ['United States Postal Service', '92001903060085300042901077'],
    ['United States Postal Service', '9400 1112 0108 0805 4830 16'],
    ['United States Postal Service', '9361 2898 7870 0317 6337 95'],
    ['United States Postal Service', '9405803699300124287899'],
]);

// it('can analyze a tracking number', function (): void {
//     // $result = (new Analyzer())->analyze('03071790000523483741');
//     // $result = (new Analyzer())->analyze('1ZA92F066796768899');
//     // $result = (new Analyzer())->analyze('373325384857408853');
//     $result = (new Analyzer())->analyze('MH498594222FI');
//     // $result = (new Analyzer())->analyze('JJFI65838710058291085');
//     // $result = (new Analyzer())->analyze('CE907369965FI');
//     // $result = (new Analyzer())->analyze('903245100704');

//     dump($result);

//     expect($result)->toBeInstanceOf(TrackingNumber::class);
// })->skip();
