<?php

return [
    'contact_email' => env('CONTACT_EMAIL', 'contacto@primeroelvoleibol.es'),
    'cc_emails' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('CONTACT_CC_EMAILS', 'javier.arrua@primeroelvoleibol.es,javier.martin@primeroelvoleibol.es,juanlu@primeroelvoleibol.es,paco@primeroelvoleibol.es,chacho@primeroelvoleibol.es')),
    ))),
];
