<?php

declare(strict_types=1);

return [
    'paymentType' => [
        'KART'         => 'Kredit-, Debitkarte',
        'BANKA_HAVALE' => 'Banküberweisung',
        'YURT_DISI'    => 'Kredit-, Debitkarte (Ausland)',
    ],

    'productNameTooLong'    => 'Produktbezeichnung muss kürzer als 200 Zeichen lang sein.',
    'credentialsNotSet'     => 'Benutzername, Passwort und Shop-Code müssen festgelegt sein.',
    'callbackOkUrlNotSet'   => 'Callback-OK-URL muss festgelegt sein.',
    'callbackFailUrlNotSet' => 'Callback-Fail-URL muss festgelegt sein.',
    'fieldNotSet'           => 'Feld :field muss festgelegt sein.',
    'amountNotSet'          => 'Der Betrag muss festgelegt sein.',
    'orderIdNotSet'         => 'Die Auftragsnummer muss festgelegt sein.',
    'requestFailed'         => 'Anfrage fehlgeschlagen.',
    'invalidEmail'          => 'Ungültige E-Mail-Adresse.',
    'invalidIpAddress'      => 'Ungültige IP-Adresse.',
];
