<?php

function nx_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function nx_form_flash_boot($sessionKey, array $defaults)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $flash = $_SESSION[$sessionKey] ?? [];
    unset($_SESSION[$sessionKey]);

    $values = $defaults;
    if (isset($flash['values']) && is_array($flash['values'])) {
        $values = array_merge($defaults, $flash['values']);
    }

    return [
        'status' => isset($flash['status']) ? (string) $flash['status'] : '',
        'message' => isset($flash['message']) ? (string) $flash['message'] : '',
        'values' => $values,
        'errors' => isset($flash['errors']) && is_array($flash['errors']) ? $flash['errors'] : [],
        'field_errors' => isset($flash['field_errors']) && is_array($flash['field_errors']) ? $flash['field_errors'] : [],
    ];
}

function nx_form_flash_redirect($sessionKey, $path, array $payload)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION[$sessionKey] = $payload;
    header('Location: ' . $path);
    exit;
}

function nx_mail_config()
{
    $config = [
        'host' => getenv('SMTP_HOST') ?: '',
        'port' => getenv('SMTP_PORT') ?: 587,
        'encryption' => getenv('SMTP_ENCRYPTION') ?: 'tls',
        'username' => getenv('SMTP_USERNAME') ?: '',
        'password' => getenv('SMTP_PASSWORD') ?: '',
        'from_email' => getenv('SMTP_FROM_EMAIL') ?: '',
        'from_name' => getenv('SMTP_FROM_NAME') ?: 'Nexgeno Partners Website',
        'to_email' => getenv('SMTP_TO_EMAIL') ?: 'info@nexgeno.in',
        'to_name' => getenv('SMTP_TO_NAME') ?: 'Nexgeno Partners',
        'timeout' => getenv('SMTP_TIMEOUT') ?: 20,
        'verify_peer' => getenv('SMTP_VERIFY_PEER') !== false ? getenv('SMTP_VERIFY_PEER') : false,
        'allow_self_signed' => getenv('SMTP_ALLOW_SELF_SIGNED') !== false ? getenv('SMTP_ALLOW_SELF_SIGNED') : true,
    ];

    $localConfigFile = __DIR__ . '/smtp_config.php';
    if (is_file($localConfigFile)) {
        $localConfig = require $localConfigFile;
        if (is_array($localConfig)) {
            $config = array_merge($config, $localConfig);
        }
    }

    $config['host'] = trim((string) $config['host']);
    $config['port'] = (int) $config['port'];
    $config['port'] = $config['port'] > 0 ? $config['port'] : 587;
    $config['encryption'] = strtolower(trim((string) $config['encryption']));
    $config['encryption'] = in_array($config['encryption'], ['tls', 'ssl', 'none', ''], true) ? $config['encryption'] : 'tls';
    $config['encryption'] = $config['encryption'] === '' ? 'tls' : $config['encryption'];
    $config['username'] = trim((string) $config['username']);
    $config['password'] = (string) $config['password'];
    $config['from_email'] = trim((string) $config['from_email']);
    $config['from_name'] = trim((string) $config['from_name']);
    $config['to_email'] = trim((string) $config['to_email']);
    $config['to_name'] = trim((string) $config['to_name']);
    $config['timeout'] = (int) $config['timeout'];
    $config['timeout'] = $config['timeout'] > 0 ? $config['timeout'] : 20;
    $config['verify_peer'] = filter_var($config['verify_peer'], FILTER_VALIDATE_BOOLEAN);
    $config['allow_self_signed'] = filter_var($config['allow_self_signed'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    $config['allow_self_signed'] = $config['allow_self_signed'] === null ? true : $config['allow_self_signed'];

    return $config;
}

function nx_mail_is_configured(array $config)
{
    return $config['host'] !== ''
        && $config['from_email'] !== ''
        && $config['to_email'] !== '';
}

function nx_send_smtp_mail(array $message)
{
    $config = nx_mail_config();

    if (!nx_mail_is_configured($config)) {
        return [
            'success' => false,
            'error' => 'SMTP settings are incomplete. Update smtp_config.php or set the SMTP_* environment variables.',
        ];
    }

    if ($config['username'] === '' || $config['password'] === '') {
        return [
            'success' => false,
            'error' => 'SMTP username or password is missing in the mail configuration.',
        ];
    }

    $recipients = nx_normalize_email_contacts($message['to'] ?? [
        [
            'email' => $config['to_email'],
            'name' => $config['to_name'],
        ],
    ]);

    $replyTo = nx_normalize_email_contacts($message['reply_to'] ?? []);
    $replyTo = $replyTo !== [] ? $replyTo[0] : null;

    $subject = trim((string) ($message['subject'] ?? 'Website enquiry'));
    $textBody = (string) ($message['text_body'] ?? '');
    $htmlBody = (string) ($message['html_body'] ?? '');

    if ($subject === '') {
        return [
            'success' => false,
            'error' => 'Email subject cannot be empty.',
        ];
    }

    if ($textBody === '' && $htmlBody === '') {
        return [
            'success' => false,
            'error' => 'Email body cannot be empty.',
        ];
    }

    if ($textBody === '') {
        $textBody = trim(html_entity_decode(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody)), ENT_QUOTES, 'UTF-8'));
    }

    if ($htmlBody === '') {
        $htmlBody = '<pre style="font-family:Arial,Helvetica,sans-serif;white-space:pre-wrap;">' . nx_h($textBody) . '</pre>';
    }

    try {
        $rawMessage = nx_build_mime_message($config, $recipients, $replyTo, $subject, $textBody, $htmlBody);
        nx_smtp_deliver($config, $recipients, $rawMessage);

        return [
            'success' => true,
            'error' => '',
        ];
    } catch (Throwable $exception) {
        return [
            'success' => false,
            'error' => $exception->getMessage(),
        ];
    }
}

function nx_build_email_bodies($title, $intro, array $rows)
{
    $textLines = [];
    if ($intro !== '') {
        $textLines[] = $intro;
        $textLines[] = '';
    }

    foreach ($rows as $label => $value) {
        $textLines[] = $label . ': ' . $value;
    }

    $htmlRows = '';
    foreach ($rows as $label => $value) {
        $htmlRows .= '<tr>'
            . '<td style="padding:12px 14px;border:1px solid #e5e7eb;background:#f8fafc;font-weight:700;width:180px;vertical-align:top;">' . nx_h($label) . '</td>'
            . '<td style="padding:12px 14px;border:1px solid #e5e7eb;vertical-align:top;">' . nl2br(nx_h($value)) . '</td>'
            . '</tr>';
    }

    $html = '<div style="font-family:Arial,Helvetica,sans-serif;color:#1f2937;line-height:1.6;">'
        . '<h2 style="margin:0 0 12px;font-size:22px;color:#111827;">' . nx_h($title) . '</h2>';

    if ($intro !== '') {
        $html .= '<p style="margin:0 0 18px;">' . nl2br(nx_h($intro)) . '</p>';
    }

    $html .= '<table style="width:100%;border-collapse:collapse;border:1px solid #e5e7eb;">'
        . $htmlRows
        . '</table>'
        . '</div>';

    return [
        'text' => implode("\n", $textLines),
        'html' => $html,
    ];
}

function nx_normalize_email_contacts($contacts)
{
    if (isset($contacts['email'])) {
        $contacts = [$contacts];
    }

    $normalized = [];
    foreach ((array) $contacts as $contact) {
        if (!is_array($contact)) {
            continue;
        }

        $email = trim((string) ($contact['email'] ?? ''));
        $name = trim((string) ($contact['name'] ?? ''));

        if ($email === '') {
            continue;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email address in SMTP message payload: ' . $email);
        }

        $normalized[] = [
            'email' => $email,
            'name' => $name,
        ];
    }

    return $normalized;
}

function nx_build_mime_message(array $config, array $recipients, $replyTo, $subject, $textBody, $htmlBody)
{
    $boundary = 'nx-part-' . bin2hex(random_bytes(12));
    $hostname = nx_smtp_hostname();
    $headers = [
        'Date: ' . date('r'),
        'From: ' . nx_format_email_contact([
            'email' => $config['from_email'],
            'name' => $config['from_name'],
        ]),
        'To: ' . implode(', ', array_map('nx_format_email_contact', $recipients)),
        'Subject: ' . nx_encode_mime_header($subject),
        'Message-ID: <' . bin2hex(random_bytes(10)) . '@' . $hostname . '>',
        'MIME-Version: 1.0',
        'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        'X-Mailer: Nexgeno SMTP Mailer',
    ];

    if (is_array($replyTo)) {
        $headers[] = 'Reply-To: ' . nx_format_email_contact($replyTo);
    }

    $message = implode("\r\n", $headers) . "\r\n\r\n";
    $message .= '--' . $boundary . "\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
    $message .= quoted_printable_encode(str_replace(["\r\n", "\r"], "\n", $textBody)) . "\r\n\r\n";
    $message .= '--' . $boundary . "\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
    $message .= quoted_printable_encode(str_replace(["\r\n", "\r"], "\n", $htmlBody)) . "\r\n\r\n";
    $message .= '--' . $boundary . "--\r\n";

    return $message;
}

function nx_smtp_deliver(array $config, array $recipients, $rawMessage)
{
    $socket = nx_smtp_open_socket($config);

    try {
        nx_smtp_expect($socket, [220]);
        $ehloResponse = nx_smtp_command($socket, 'EHLO ' . nx_smtp_hostname(), [250]);

        if ($config['encryption'] === 'tls') {
            nx_smtp_command($socket, 'STARTTLS', [220]);

            $cryptoEnabled = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            if ($cryptoEnabled !== true) {
                throw new RuntimeException('Unable to start TLS encryption for the SMTP connection.');
            }

            $ehloResponse = nx_smtp_command($socket, 'EHLO ' . nx_smtp_hostname(), [250]);
        }

        nx_smtp_authenticate($socket, $config, $ehloResponse['lines']);
        nx_smtp_command($socket, 'MAIL FROM:<' . $config['from_email'] . '>', [250]);

        foreach ($recipients as $recipient) {
            nx_smtp_command($socket, 'RCPT TO:<' . $recipient['email'] . '>', [250, 251]);
        }

        nx_smtp_command($socket, 'DATA', [354]);
        fwrite($socket, nx_smtp_dot_stuff($rawMessage) . "\r\n.\r\n");
        nx_smtp_expect($socket, [250]);
        nx_smtp_command($socket, 'QUIT', [221]);
    } finally {
        fclose($socket);
    }
}

function nx_smtp_open_socket(array $config)
{
    $transport = $config['host'] . ':' . $config['port'];
    if ($config['encryption'] === 'ssl') {
        $transport = 'ssl://' . $transport;
    }

    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => $config['verify_peer'],
            'verify_peer_name' => $config['verify_peer'],
            'allow_self_signed' => $config['allow_self_signed'],
            'SNI_enabled' => true,
            'peer_name' => $config['host'],
        ],
    ]);

    $socket = @stream_socket_client(
        $transport,
        $errorNumber,
        $errorMessage,
        $config['timeout'],
        STREAM_CLIENT_CONNECT,
        $context
    );

    if (!is_resource($socket)) {
        throw new RuntimeException('SMTP connection failed: ' . $errorMessage . ' (' . $errorNumber . ').');
    }

    stream_set_timeout($socket, $config['timeout']);

    return $socket;
}

function nx_smtp_authenticate($socket, array $config, array $ehloLines)
{
    $username = $config['username'];
    $password = $config['password'];

    if ($username === '' && $password === '') {
        return;
    }

    $authLine = '';
    foreach ($ehloLines as $line) {
        if (stripos($line, 'AUTH ') !== false) {
            $authLine = strtoupper($line);
            break;
        }
    }

    if ($authLine !== '' && strpos($authLine, 'PLAIN') !== false) {
        nx_smtp_command($socket, 'AUTH PLAIN ' . base64_encode("\0" . $username . "\0" . $password), [235]);
        return;
    }

    nx_smtp_command($socket, 'AUTH LOGIN', [334]);
    nx_smtp_command($socket, base64_encode($username), [334]);
    nx_smtp_command($socket, base64_encode($password), [235]);
}

function nx_smtp_command($socket, $command, array $expectedCodes)
{
    fwrite($socket, $command . "\r\n");
    return nx_smtp_expect($socket, $expectedCodes);
}

function nx_smtp_expect($socket, array $expectedCodes)
{
    $response = nx_smtp_read_response($socket);
    if (!in_array($response['code'], $expectedCodes, true)) {
        throw new RuntimeException('SMTP error: ' . $response['message']);
    }

    return $response;
}

function nx_smtp_read_response($socket)
{
    $lines = [];
    $code = 0;

    while (($line = fgets($socket, 515)) !== false) {
        $line = rtrim($line, "\r\n");
        $lines[] = $line;

        if (preg_match('/^(\d{3})([ -])/', $line, $matches)) {
            $code = (int) $matches[1];
            if ($matches[2] === ' ') {
                break;
            }
        } else {
            break;
        }
    }

    if ($lines === []) {
        throw new RuntimeException('No response received from the SMTP server.');
    }

    return [
        'code' => $code,
        'message' => implode(' | ', $lines),
        'lines' => $lines,
    ];
}

function nx_smtp_dot_stuff($message)
{
    $normalized = str_replace(["\r\n", "\r"], "\n", $message);
    $lines = explode("\n", $normalized);

    foreach ($lines as &$line) {
        if (str_starts_with($line, '.')) {
            $line = '.' . $line;
        }
    }
    unset($line);

    return implode("\r\n", $lines);
}

function nx_smtp_hostname()
{
    $hostname = $_SERVER['SERVER_NAME'] ?? gethostname() ?: 'localhost';
    $hostname = preg_replace('/[^A-Za-z0-9.-]/', '', (string) $hostname);

    return $hostname !== '' ? $hostname : 'localhost';
}

function nx_format_email_contact(array $contact)
{
    $email = trim((string) ($contact['email'] ?? ''));
    $name = trim((string) ($contact['name'] ?? ''));

    if ($name === '') {
        return '<' . $email . '>';
    }

    return nx_encode_mime_header($name) . ' <' . $email . '>';
}

function nx_encode_mime_header($value)
{
    $value = trim(preg_replace('/\s+/', ' ', str_replace(["\r", "\n"], ' ', (string) $value)));
    if ($value === '') {
        return '';
    }

    return '=?UTF-8?B?' . base64_encode($value) . '?=';
}
