<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Portfolio Contact Message</title>
</head>
<body style="margin: 0; padding: 0; background: #f4f3f8; font-family: Arial, sans-serif; color: #1a1b1f;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background: #f4f3f8; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 640px; background: #ffffff; border: 1px solid #e3e2e7; border-radius: 12px; overflow: hidden;">
                    <tr>
                        <td style="padding: 28px 32px; background: #0058bc; color: #ffffff;">
                            <p style="margin: 0 0 8px; font-size: 12px; letter-spacing: 0.12em; text-transform: uppercase;">Nawaf Portfolio</p>
                            <h1 style="margin: 0; font-size: 24px; line-height: 1.3;">New contact message</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 28px 32px;">
                            <p style="margin: 0 0 18px; color: #414755;">
                                Someone sent a message from your portfolio contact form.
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding: 10px 0; color: #717786; width: 120px;">Name</td>
                                    <td style="padding: 10px 0; font-weight: 700;">{{ $contact['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #717786;">Email</td>
                                    <td style="padding: 10px 0;">
                                        <a href="mailto:{{ $contact['email'] }}" style="color: #0058bc;">{{ $contact['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #717786;">Subject</td>
                                    <td style="padding: 10px 0; font-weight: 700;">{{ $contact['subject'] }}</td>
                                </tr>
                            </table>

                            <div style="margin-top: 22px; padding: 18px; background: #f4f3f8; border-radius: 10px; border: 1px solid #e3e2e7;">
                                <p style="margin: 0; white-space: pre-line; line-height: 1.7;">{{ $contact['message'] }}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
