@props(['subject' => null, 'body' => null])

@php
    $dev = config('portfolio.developer');
    $contact = config('portfolio.contact');

    $mailSubject = $subject ?? __($contact['subject']);
    $mailBody = $body ?? __($contact['body']);

    /*
     | Opens Gmail's compose window already addressed, with a subject filled in,
     | so the visitor only has to type their message and press send.
     |
     | mailto: was the old behaviour, but it hands off to whatever the operating
     | system has registered as the default mail client - which on most machines
     | is nothing at all, or an Outlook install nobody signed into. The result
     | was a button that appeared to do nothing.
     |
     | Anyone who does not use Gmail is covered by the "use your own mail app"
     | mailto link and the copy-address button in the contact section.
     */
    $composeUrl = 'https://mail.google.com/mail/?view=cm&fs=1'
        . '&to=' . rawurlencode($dev['email'])
        . '&su=' . rawurlencode($mailSubject)
        . '&body=' . rawurlencode($mailBody);
@endphp

<a
    href="{{ $composeUrl }}"
    target="_blank"
    rel="noopener noreferrer"
    {{ $attributes }}
>{{ $slot }}</a>
