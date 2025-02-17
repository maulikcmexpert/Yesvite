<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePen - Email Newsletter Template</title>
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.cdnfonts.com/css/sf-pro-display');
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap');

        a {
            text-decoration: none;
        }
    </style>
</head>

<body style="font-family: 'SF Pro Display', sans-serif !important;margin: 0px;background: #F8F8F8;display: flex;justify-content: center;">
    <!-- partial:index.partial.html -->
    <div style="width: 100%;max-width: 650px;height:100%;padding: 0px 10px;margin: 50px 0px" class="ui-sortable">
        <table style="border-radius: 5px;box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3);width: 100%;height:100%;background: #fff;box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3);padding: 30px;border-radius: 20px;" class="full selected-table" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div style="width: 100%;max-width: 150px;height:40px">
                            <img src="{{ asset('public/storage/yesvitelogo.png')}}" style="width: 100%;max-width: 150px;height:40px" alt="logo">
                        </div>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="35" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <h4 style="font-size: 20px;line-height: 28px;font-weight: 700;color: #0F172A;margin: 0px 0px;">Thanks for joining us!! . <span style="font-weight: 400;"> Really enjoyed having you guys over for the party!</span></h4>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="25" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <div class="invited-img" style="width: 100%;max-width: 300px;height: 430px;border-radius: 10px;">
                            <img src="{{ asset('public/storage/event_images/'.$eventData['event_image'])}}" alt="" style="width: 100%;height: 100%;border-radius: 10px;">
                        </div>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="20" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <div class="view-btn" style="display: flex;align-items: center;gap: 15px;">
                            <button style="font-family: 'SF Pro Display', sans-serif;font-size: 14px;line-height: 20px;font-weight: 500;color: #0F172A;background: transparent;border: 1px solid #E2E8F0;border-radius: 10px; padding: 10px 24px 10px 24px;width: 100%;max-width: 300px;">Message Host</button>
                        </div>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="30" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <p style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 500;color: #0F172A;">Please add <a href="" style="font-size: 12px;line-height: 20px;font-weight: 700;color: #0F172A;">contact@yesvite.com</a> to your contacts so the email does not go to your SPAM folder.</p>
                        <p style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 500;color: #0F172A;">If you don’t want to receive these notifications please update your <a href="" style="color: #F73C71;font-weight: 700;text-transform: capitalize;">account settings >Notifications.</a></p>
                        <p style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 500;color: #0F172A;">You have received this email from <a href="" style="color: #F73C71;font-weight: 700;">contact@yesvite.com</a> on behalf of <a href="" style="color: #F73C71;font-weight: 700;">ekuanox@gmail.com</a>.</p>
                        <p style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 500;color: #0F172A;">© Yesvite {{date('Y')}}</p>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="10" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <div class="download-form-img" style="display: flex;align-items: center;gap: 10px;">
                            <a href="#" style="width: 100%;max-width: 120px;height: 40px;border-radius: 5px;display: block;"><img src="{{ asset('public/storage/google-play.png')}}" alt="" style="width: 100%;height: 100%;"></a>
                            <a href="#" style="width: 100%;max-width: 120px;height: 40px;border-radius: 5px;display: block;"><img src="{{ asset('public/storage/app-store.png')}}" alt="" style="width: 100%;height: 100%;"></a>
                        </div>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="30" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <div class="social-icons" style="display: flex;align-items: center;justify-content: space-between;">
                            <div style="width: 100%;max-width: 95px;height: 24px;"><img src="{{ asset('public/storage/yesvitelogo.png')}}" alt="" style="width: 100%;height: 100%;"></div>
                            <ul style="display: flex;align-items: center;gap: 10px;margin: 0px 0px;">
                                <li style="list-style-type: none;"><a href="" style="color: #475569;width: 100%;max-width: 16px;height: 16px;"><i class="fa-brands fa-facebook"></i></a></li>
                                <li style="list-style-type: none;"><a href="" style="color: #475569;width: 100%;max-width: 16px;height: 16px;"><i class="fa-brands fa-twitter"></i></a></li>
                                <li style="list-style-type: none;"><a href="" style="color: #475569;width: 100%;max-width: 16px;height: 16px;"><i class="fa-brands fa-apple" style="font-size: 18px;"></i></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td height="20" style="font-size:0px">&nbsp;</td>
                </tr>
                <!-- -------------- -->
                <tr>
                    <td>
                        <p style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 700;color: #0F172A;margin: 0px;">Invite Email: <span style="font-family:'Manrope';font-size: 12px;line-height: 20px;font-weight: 500;color: #0F172A;">crisilis@hotmail.com</span></p>
                    </td>
                </tr>
                <!-- -------------- -->
            </tbody>
        </table>

    </div>
    <!-- partial -->

</body>

</html>