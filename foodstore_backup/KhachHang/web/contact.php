<style>
    .mid-grid-left {
        display: none;
    }
</style>

<body>
    <?php
    include("Layout_KhachHang_Header.php");
    ?>
    <?php


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // include "PHPMailer/src/PHPMailer.php";
    // include "PHPMailer/src/Exception.php";
    // include "PHPMailer/src/OAuth.php";
    // include "PHPMailer/src/POP3.php";
    // include "PHPMailer/src/SMTP.php";


    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

        $mail->SMTPAuth = true;
        if (isset($_POST['submit'])) {                             // Enable SMTP authentication
            $mail->Username = $_POST['email'];                 // SMTP username
            $mail->Password = $_POST['password'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($_POST['email'], $_POST['name']);
            $mail->addAddress('lehoanggiang0405@gmail.com', 'LeHoangGiang');     // Add a recipient              // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');

            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $_POST['subject'];
            $mail->Body    = $_POST['message'];
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // echo "<h2 style='text-align:center;color:red;'>" . 'Gửi phản hồi thành công, chúng tôi sẽ phản hồi bạn sớm nhất!!!' . "</h2>";
            echo "<script>
			alert('Gửi phản hồi thành công, chúng tôi sẽ phản hồi bạn sớm nhất!!!');
			</script>";
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    ?>
    <div class="content contact-main">
        <!----start-contact---->
        <div class="contact-info">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.7062240321243!2d109.20018721429832!3d12.268148933243067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067ed3a052f11%3A0xd464ee0a6e53e8b7!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBOaGEgVHJhbmc!5e0!3m2!1svi!2s!4v1667818564124!5m2!1svi!2s" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="wrap">
                <div class="contact-grids">
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Địa chỉ</h5>
                        <ul class="list3">
                            <li>
                                <img src="images/home.png" alt="">
                                <div class="extra-wrap">
                                    <p>Số 113 Nguyễn Đình Chiểu<br>An Dương Vương, Q5, TP HỒ CHÍ MINH.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Số điện thoại</h5>
                        <ul class="list3">
                            <li>
                                <img src="images/phone.png" alt="">
                                <div class="extra-wrap">
                                    <p><span>Di động:</span> 0355587440</p>
                                </div>
                                <img src="images/fax.png" alt="">
                                <div class="extra-wrap">
                                    <p><span>Số fax:</span> 0355587440</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Email</h5>
                        <ul class="list3">
                            <li>
                                <img src="images/email.png" alt="">
                                <div class="extra-wrap">
                                    <p><span class="mail"><a href="mailto:yoursite.com">lehoanggiang0405@gmail.com</a></span></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <form method="post" action="">
                    <div class="contact-form">
                        <div class="contact-to">
                            <input type="text" class="text" name="name" value="Tên..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Tên...';}">
                            <input type="text" class="text" name="email" value="Email..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email...';}">
                            <input type="text" class="text" name="subject" value="Chủ đề..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Chủ đề...';}">

                            <input type="password" class="text" name="password" placeholder="Mật khẩu..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Mật khẩu...';}">


                        </div>
                        <div class="text2">
                            <textarea value="Nội dung..." name="message" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nội dung...';}">Nội dung...</textarea>
                        </div>
                        <span><input type="submit" class="" value="Gửi" name="submit"></span>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
        </div>
        <!----//End-contact---->
    </div>
    <!---- start-bottom-grids---->

    <!---- //End-bottom-grids---->
    <!--- //End-content---->
    <!---start-footer---->


    <!---//End-footer---->
    <!---//End-wrap---->
    <?php include("Layout_KhachHang_Footer.php"); ?>
</body>


</html>
<style>
    input {
        padding: 12px 10px;
        width: 30.66%;
        font-family: "Open Sans", sans-serif;
        margin: 12px 0;
        border: 1px solid rgba(192, 192, 192, 0.61);
        color: #626262;
        background: #fff;
        float: left;
        outline: none;
        font-size: 0.85em;
        transition: border-color 0.3s;
        -o-transition: border-color 0.3s;
        -ms-transition: border-color 0.3s;
        -moz-transition: border-color 0.3s;
        -webkit-transition: border-color 0.3s;
        box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
    }
</style>