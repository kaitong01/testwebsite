<?php

class Email_Fn extends Fn
{
    public function send( $options )
    {
        require_once WWW_VENDORS.'PHPMailer/class.phpmailer.php';

        $name = 'Pro Booking Center';
        $host = 'mail.csloxinfo.com';
        $user = 'support@probookingcenter.com';
        $pass = '';

        $options = array_merge( array(
            'email' => '',
            'name' => '',
            'subject' => '',
            'message' => '',
        ), $options);

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                 // Enable verbose debug output
            $mail->IsSMTP();                      // Set mailer to use SMTP
            $mail->CharSet = 'utf-8';
            $mail->Host = $host;                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = false;               // Enable SMTP authentication
            $mail->Username = $user;              // SMTP username
            $mail->Password = $pass;              // SMTP password
            // $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                    // TCP port to connect to

            $mail->SetFrom($user, $name);
            $mail->addAddress($options['email'], $options['name']);

    
            $mail->SetFrom($user, $name);
            $mail->addAddress($options['email'], $options['name']);     // Add a recipient
            
            // add: CC
            $mail->addCC("devs.pbc@gmail.com", "MAIL BCC TO DEVS PBC");
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('monkey.d.chong@gmail.com');
            // $mail->addBCC("l2iza@outlook.com", "CC Test");
            // $mail->addBCC('monkey.d.chong@gmail.com');

            // add: BCC
            /*$mail->addBCC("admin@internationalbangkokbike.com", "MAIL BCC TO ADMIN IBKB"); //BCC
            $mail->addBCC("bangkokbike@qsncc.com", "MAIL BCC TO ADMIN IBKB"); //BCC
            $mail->addBCC("supawat@atmoststudio.com", "MAIL BCC TO ADMIN IBKB"); //BCC*/

            // add: Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $options['subject'];
            $mail->Body = $options['message'];

            // $mail->Subject = 'Test Mail';
            // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // echo 'Send => '.$options['email'];
        } catch (Exception $e) {
            // echo 'Error => Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }


    public function theme_event( $options=array() )
    {

        $app_url = 'https://probookingcenter.com/';

        $title_bgcolor = '#151143';
        $title = 'Pro Booking Center';
        $logo = 'https://office.probookingcenter.com/public/images/email/logo.png';

        $copyright = '© 2018 Jitwilai Group, All rights reserved.';
        $callCenter = '02-935-8550';

        $socialList = array();
        $socialList[] = array('title'=>'Facebook', 'link'=> 'https://www.facebook.com/probookingcenter', 'image_url'=>'https://office.probookingcenter.com/public/images/email/facebook.png');
        $socialList[] = array('title'=>'Line', 'link'=> 'http://line.me/ti/p/~@probookingcenter', 'image_url'=>'https://office.probookingcenter.com/public/images/email/line.png');

        $socialList_str = '';
        foreach ($socialList as $key => $value) {
            $socialList_str .= '<td valign="top" style="padding:0px 5px"><a role="social-icon-link" href="'.$value['link'].'" target="_blank"><img role="social-icon" alt="'.$value['title'].'" title="'.$value['title'].' " height="30" width="30" src="'.$value['image_url'].'"></a></td>';
        }

        $options = array_merge(array(
            'banner_url' => 'https://agent.probookingcenter.com/public/images/events/thank-you-party-2018_640x400.jpg',
            'title' => 'THANK YOU PARTY 2018<br />"ขอบคุณที่มีกัน"',
            'date' => '10 OCTOBER 2018 6PM ON WARD',
            'location' => 'The Public Restaurant & Bar - Bangkok, Thailand',

            'company' => '',
            'name' => '',

            'ref' => '',
        ), $options);

        // print_r($options); die;


        $options['qrcode'] = 'https://agent.probookingcenter.com/app/phpqrcode/qrcode.php?text='.$options['ref'].'&size=250';
        $options['barcode'] = 'https://agent.probookingcenter.com/app/phpbarcode/barcode.php?text='.$options['ref'];
        
        return '<table align="center" bgcolor="#eeebeb" border="0" cellpadding="0" cellspacing="0" width="100%">'.
            '<tbody>'.

                
                '<tr>
                    <td align="center" valign="top" style="padding-top:40px">
                        <table align="center" valign="top" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="max-width:640px" width="100%">
                            <tbody>'.
                                    // banner
                                '<tr><td align="center" valign="top"><img alt="" src="'.$options['banner_url'].'" width="640" height="400" /></td></tr>'.

                                // 
                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.

                                // title
                                '<tr><td align="center" valign="top"><h1 style="color:#000000;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;font-weight:600;letter-spacing:normal;margin:0;padding:0;text-align:center">WELCOME YOU TO</h1></td></tr>'.
                                '<tr><td align="center" valign="top"><h1 style="color:#1d0aef;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:22px;font-style:normal;font-weight:600;letter-spacing:normal;margin:0;padding:0;text-align:center">PRO BOOKING CENTER</h1></td></tr>'.

                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.
                                '<tr><td align="center" valign="top"><h1 style="color:#c20003;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:18px;font-style:normal;font-weight:600;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$options['title'].'</h1></td></tr>'.

                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.
                                '<tr><td align="center" valign="top"><span style="color:#000000;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$options['date'].'</span></td></tr>'.
                                '<tr><td align="center" valign="top"><span style="color:#000000;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$options['location'].'</span></td></tr>'.


                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.
                                '<tr><td align="center" valign="top"><h4 style="color:#000000;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:16px;font-style:normal;letter-spacing:normal;margin:0;padding:0;text-align:center">PARKING IS AVAILABLE<br />FOR MORE INFO PLS CONTACT : 088-249-9542</h4></td></tr>'.


                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.
                                '<tr><td style="padding:0 15px"><hr style="border-style:solid;border-color:#ddd"></td></tr>'.
                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.

                                // name
                                '<tr><td align="center" valign="top"><span style="color:#4CAF50;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:18px;font-style:normal;font-weight:600;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$options['company'].'</span></td></tr>'.
                                '<tr><td align="center" valign="top"><span style="color:#4CAF50;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:20px;font-style:normal;font-weight:600;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$options['name'].'</span></td></tr>'.

                                // code
                                '<tr><td align="center" valign="top"><img alt="" src="'.$options['qrcode'].'" width="250" height="250" /></td></tr>'.
                                '<tr><td>&nbsp;</td></tr>'.
                                '<tr><td align="center" valign="top"><img alt="" src="'.$options['barcode'].'" width="200" height="50" /></td></tr>'.
                                '<tr><td align="center" valign="top"><h4 style="margin-top:5px;margin-bottom:0">REF: '.$options['ref'].'</td></h4></tr>'.


                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.
                                '<tr><td style="padding:0 15px"><hr style="border-style:solid;border-color:#ddd"></td></tr>'.
                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.


                                '<tr><td align="center" valign="top"><a style="background-color:#255ed0; border-collapse:separate; border-top:10px solid #255ed0; border-right:20px solid #255ed0; border-bottom:10px solid #255ed0; border-left:20px solid #255ed0; border-radius:3px; color:#ffffff; display:inline-block; font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size:16px; font-weight:600; letter-spacing:.3px; text-decoration:none" target="_blank" href="https://goo.gl/maps/JpMUom4Nb2w">เส้นทาง</a></td></tr>'.

                                '<tr><td style="padding-top:10px">&nbsp;</td></tr>'.

                            '</tbody>
                        </table>
                    </td>
                </tr>'.

                // footer
                '<tr>
                    <td align="center" valign="top" style="padding-top:40px">
                        <table align="center" valign="top" border="0" cellpadding="0" cellspacing="0" style="max-width:640px" width="100%">
                            <tbody>'.

                                '<tr>
                                    <td align="center" valign="top"><a href="'.$app_url.'" target="_blank"><img alt="'.$title.'" src="'.$logo.'" width="160" /></a></td>
                                </tr>'.

                                '<tr>
                                    <td valign="top" align="center"><h1 style="color:#c20003;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:30px;font-style:normal;font-weight:600;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">'.$callCenter.'</h1></td>
                                </tr>'.

                                '<tr>
                                    <td>
                                        <table align="center" valign="top" border="0" cellpadding="0" cellspacing="0" style="color:#151143;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding-right: 10px">Office Hours : </td>
                                                    <td valign="top">
                                                        <table align="center" valign="top" border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top">9.00 - 18.00</td>
                                                                    <td valign="top">&nbsp;</td>
                                                                    <td valign="top">MON-FRI</td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top">9.00 - 15.00</td>
                                                                    <td valign="top">&nbsp;</td>
                                                                    <td valign="top">SAT</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>'.

                                // social
                                '<tr>
                                    <td valign="top" style="padding-top:30px;font-size:6px;">
                                        <table align="center"><tbody>'.
                                            '<tr>'.$socialList_str.'</tr>'.
                                        '</tbody></table>'.
                                    '</td>'.
                                '</tr>'.

                                '<tr>
                                    <td valign="top" align="center" style="padding: 10px 0 0"><span style="font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;line-height:21px;font-family:arial,helvetica,sans-serif;font-size:12px;color:#151143;text-align:center">'.$copyright.'</span></td>
                                </tr>'.

                                '<tr>
                                    <td valign="top" align="center" style="padding:2px 0 40px ">
                                        <table valign="top" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" align="center" ><a href="'.$app_url.'" target="_blank" style="font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;line-height:21px;font-family:arial,helvetica,sans-serif;font-size:12px;color:#151143;text-align:center">View in browser</a>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>'.

                            '</tbody>
                        </table>
                    </td>
                </tr>'.

            '</tbody>'.
        '</table>';
    }


    public function password_reset($token='')
    {
        $link = 'https://probookingcenter.com/agent/password_reset/'.$token;


        return '<table align="center" bgcolor="#eeebeb" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>'.

            '<tr><td align="center" valign="top" style="padding:40px 20px"><table align="center" valign="top" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="max-width:640px;color:#000" width="100%"><tbody>'.

                '<tr><td style="padding:40px 20px 10px">รีเซ็ตรหัสผ่าน!</td></tr>'.
                '<tr><td style="padding:10px 20px 0">คุณสามารถใช้ลิงค์ต่อไปนี้เพื่อรีเซ็ตรหัสผ่านของคุณ:</td></tr>'.
                '<tr><td style="padding:10px 20px;"><a href="'.$link.'" target="_blank" style="color:#286efa">'.$link.'</a></td></tr>'.
                '<tr><td style="padding:10px 20px 40px">หากคุณไม่ได้ใช้ลิงก์นี้ภายใน 3 ชั่วโมงมันจะหมดอายุ หากต้องการรับลิงค์รีเซ็ตรหัสผ่านใหม่ให้ไปที่ <a href="https://probookingcenter.com/agent/password_reset" target="_blank" style="color:#286efa">https://probookingcenter.com/agent/password_reset</a></td></tr>'.
                
            '</tbody></table></td></tr>'.
        '</tbody></table>';
        
    }
}